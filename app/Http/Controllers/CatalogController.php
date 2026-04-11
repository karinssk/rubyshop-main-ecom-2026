<?php

namespace App\Http\Controllers;

use Botble\Theme\Facades\Theme;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CatalogController extends Controller
{
    public function index(): View|string
    {
        return $this->renderCatalogPage(1);
    }

    public function showPage(int $page): View|string
    {
        return $this->renderCatalogPage(max($page, 1));
    }

    public function file(): BinaryFileResponse
    {
        $path = base_path('Rubyshop Catalog.pdf');

        abort_unless(is_file($path), 404, 'Catalog file not found');

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Rubyshop Catalog.pdf"',
        ]);
    }

    protected function renderCatalogPage(int $page): View|string
    {
        Theme::layout('full-width');
        Theme::set('pageTitle', __('Rubyshop Catalog'));
        Theme::breadcrumb()
            ->add(__('หน้าหลัก'), route('public.index'))
            ->add(__('Catalog'), route('catalog.index'));

        return Theme::scope('custom.catalog', [
            'page' => $page,
            'pdfUrl' => route('catalog.file') . '#page=' . $page . '&zoom=page-width',
            'prevPageUrl' => $page > 1 ? route('catalog.page', ['page' => $page - 1]) : null,
            'nextPageUrl' => route('catalog.page', ['page' => $page + 1]),
        ])->render();
    }
}
