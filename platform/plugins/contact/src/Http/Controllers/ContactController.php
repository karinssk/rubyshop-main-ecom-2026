<?php

namespace Botble\Contact\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\EmailHandler;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Exceptions\DisabledInDemoModeException;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Forms\ContactForm;
use Botble\Contact\Http\Requests\ContactReplyRequest;
use Botble\Contact\Http\Requests\EditContactRequest;
use Botble\Contact\Models\Contact;
use Botble\Contact\Models\ContactReply;
use Botble\Contact\Tables\ContactTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class ContactController extends BaseController
{
    public function index(ContactTable $dataTable)
    {
        Assets::addScriptsDirectly('vendor/core/plugins/contact/js/contact.js?v=20260403-debug-delete-all');

        $this->pageTitle(trans('plugins/contact::contact.menu'));

        return $dataTable->renderTable();
    }

    public function edit(Contact $contact)
    {
        $this
            ->breadcrumb()
            ->add(trans('plugins/contact::contact.menu'), route('contacts.index'));

        $this->pageTitle(trans('plugins/contact::contact.edit'));

        return ContactForm::createFromModel($contact)->renderForm();
    }

    public function update(Contact $contact, EditContactRequest $request)
    {
        ContactForm::createFromModel($contact)->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousRoute('contacts.index')
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Contact $contact)
    {
        return DeleteResourceAction::make($contact);
    }

    public function destroyAll()
    {
        $request = request();

        Log::info('[contacts.destroyAll] Request received', [
            'method' => $request->method(),
            'path' => $request->path(),
            'user_id' => auth()->id(),
            'contact_count_before' => Contact::query()->count(),
            'reply_count_before' => ContactReply::query()->count(),
        ]);

        try {
            if (BaseHelper::hasDemoModeEnabled()) {
                Log::warning('[contacts.destroyAll] Aborted because demo mode is enabled');

                throw new DisabledInDemoModeException();
            }

            $deletedContacts = 0;
            $deletedReplies = 0;

            DB::transaction(function () use (&$deletedContacts, &$deletedReplies): void {
                $deletedReplies = ContactReply::query()->delete();

                Log::info('[contacts.destroyAll] Deleted contact replies', [
                    'deleted_replies' => $deletedReplies,
                ]);

                Contact::query()
                    ->select('id')
                    ->chunkById(100, function ($contacts) use (&$deletedContacts): void {
                        $contactIds = $contacts->pluck('id')->all();

                        Log::info('[contacts.destroyAll] Deleting contact chunk', [
                            'chunk_size' => count($contactIds),
                            'contact_ids' => $contactIds,
                        ]);

                        foreach ($contacts as $contact) {
                            $contact->delete();

                            $deletedContacts++;

                            DeletedContentEvent::dispatch(Contact::class, request(), $contact);
                        }
                    });
            });

            Log::info('[contacts.destroyAll] Request completed', [
                'deleted_contacts' => $deletedContacts,
                'deleted_replies' => $deletedReplies,
                'contact_count_after' => Contact::query()->count(),
                'reply_count_after' => ContactReply::query()->count(),
            ]);

            return $this
                ->httpResponse()
                ->setAdditional([
                    'debug' => [
                        'deleted_contacts' => $deletedContacts,
                        'deleted_replies' => $deletedReplies,
                    ],
                ])
                ->withDeletedSuccessMessage();
        } catch (Throwable $exception) {
            Log::error('[contacts.destroyAll] Request failed', [
                'user_id' => auth()->id(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return $this
                ->httpResponse()
                ->setError()
                ->setCode(500)
                ->setMessage($exception->getMessage());
        }
    }

    public function postReply(Contact $contact, ContactReplyRequest $request)
    {
        $message = BaseHelper::clean($request->input('message'));

        if (! $message) {
            throw ValidationException::withMessages(['message' => trans('validation.required', ['attribute' => 'message'])]);
        }

        EmailHandler::send($message, sprintf('Re: %s', $contact->subject), $contact->email);

        ContactReply::query()->create([
            'message' => $message,
            'contact_id' => $contact->getKey(),
        ]);

        $contact->status = ContactStatusEnum::READ();
        $contact->save();

        return $this
            ->httpResponse()
            ->setMessage(trans('plugins/contact::contact.message_sent_success'));
    }
}
