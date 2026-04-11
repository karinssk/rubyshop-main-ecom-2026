@php
    $sectionTypeOptions = [
        'hero_section_v2' => __('Hero Section V2 (Full image)'),
        'hero_section' => __('Hero Section'),
        'primary_cta' => __('Primary CTA (Above the Fold)'),
        'trust_indicators' => __('Trust Indicators'),
        'problem_section' => __('Problem Section'),
        'solution_overview' => __('Solution Overview'),
        'key_benefits' => __('Key Benefits / Value Proposition'),
        'product_features_specifications' => __('Product Features / Specifications'),
        'how_it_works' => __('How It Works / Usage Process'),
        'before_after_results' => __('Before–After / Case Results'),
        'video_demo' => __('Video Demonstration / Demo'),
        'testimonials_reviews' => __('Testimonials / Customer Reviews'),
        'comparison' => __('Comparison (Why You vs Others)'),
        'use_cases' => __('Use Cases / Who It’s For'),
        'pricing_offer' => __('Pricing / Offer / Promotion'),
        'risk_reversal' => __('Risk Reversal (Warranty / Guarantee)'),
        'faq_section' => __('FAQ Section'),
        'secondary_cta' => __('Secondary CTA (Mid-page)'),
        'urgency_scarcity' => __('Urgency / Scarcity Element'),
        'contact_section' => __('Contact Section (Phone / LINE / Chat)'),
        'final_cta' => __('Final CTA (Strong Close)'),
        'footer_basic_legal' => __('Footer (Basic Info / Legal / Links)'),
        'related_products' => __('Related products'),
        'custom_text' => __('Custom text section'),
        'custom_html' => __('Custom HTML section'),
    ];

    $landingSections = is_array($landingSections ?? null) ? $landingSections : [];
    $heroDefaultKicker = trim((($selectedProduct->name ?? '') . ' | RUBYSHOP')) ?: 'RUBYSHOP';
    $heroDefaultTitle = '4 คน ฉาบได้เท่า 8 คน — เร็วขึ้น 5 เท่า';
    $heroDefaultContent = 'คืนทุนภายใน 3 เดือน พร้อมระบบผสมอัตโนมัติ ทำงานต่อเนื่อง ไม่สะดุด';
@endphp

<div class="mb-3">
    <p class="text-muted mb-2">{{ __('Add, remove, and reorder sections for this product landing page.') }}</p>
    <p class="text-muted mb-3">{{ __('Landing URL: /landing/{product-slug}') }}</p>

    <div id="landing-sections-list"></div>

    <button type="button" class="btn btn-sm btn-primary mt-2" id="add-landing-section">
        {{ __('Add section') }}
    </button>
</div>

<template id="landing-section-template">
    <div class="card mb-2 landing-section-item" draggable="true">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-light border drag-handle" title="{{ __('Drag to reorder') }}">↕</button>
                    <strong class="landing-section-index"></strong>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger remove-landing-section">{{ __('Remove') }}</button>
            </div>

            <div class="mb-2">
                <label class="form-label">{{ __('Type') }}</label>
                <select class="form-control section-type-input">
                    @foreach ($sectionTypeOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control section-title-input" placeholder="{{ __('Section title') }}">
            </div>

            <div class="mb-2">
                <label class="form-label">{{ __('Content') }}</label>
                <textarea class="form-control section-content-input" rows="4" placeholder="{{ __('Section content (HTML is allowed for custom HTML type).') }}"></textarea>
            </div>

            <div class="mb-2">
                <label class="form-label">{{ __('Top line text (Hero V2)') }}</label>
                <input type="text" class="form-control section-kicker-text-input" placeholder="{{ __('Optional, ex: เครื่องกรีดผนัง RUBY SHOP...') }}">
            </div>

            <div class="row g-2">
                <div class="col-md-12">
                    <label class="form-label">{{ __('Section image') }}</label>
                    <div class="image-box attachment-wrapper section-image-wrapper">
                        <input class="attachment-url section-image-input" type="hidden">

                        <div class="position-relative">
                            <div class="d-flex align-items-center gap-1 attachment-details form-control mb-2 pe-5 hidden">
                                <div class="attachment-info text-truncate"></div>
                            </div>

                            <a
                                href="javascript:void(0);"
                                class="text-body text-decoration-none position-absolute end-0 me-2"
                                style="top: 0.5rem; display: none;"
                                data-bb-toggle="media-file-remove"
                                title="{{ __('Remove file') }}"
                            >
                                ✕
                            </a>
                        </div>

                        <div class="image-box-actions">
                            <a
                                href="javascript:void(0);"
                                class="btn_gallery"
                                data-action="attachment"
                            >
                                {{ __('Choose / Upload image') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Top line color') }}</label>
                    <input type="color" class="form-control form-control-color section-kicker-color-input" value="#ffffff">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Headline color') }}</label>
                    <input type="color" class="form-control form-control-color section-headline-color-input" value="#ffffff">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Subheadline color') }}</label>
                    <input type="color" class="form-control form-control-color section-subheadline-color-input" value="#ffffff">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Backdrop color') }}</label>
                    <input type="color" class="form-control form-control-color section-backdrop-color-input" value="#000000">
                </div>
                <div class="col-md-4">
                    <label class="form-label">{{ __('Backdrop opacity (0-100)') }}</label>
                    <input type="number" min="0" max="100" class="form-control section-backdrop-opacity-input" placeholder="{{ __('Optional, ex: 65') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Button text') }}</label>
                    <input type="text" class="form-control section-button-text-input" placeholder="{{ __('Optional') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('Button URL') }}</label>
                    <input type="text" class="form-control section-button-url-input" placeholder="{{ __('Optional URL') }}">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    (() => {
        const initialSections = @json($landingSections);
        const heroDefaults = {
            kicker_text: @json($heroDefaultKicker),
            title: @json($heroDefaultTitle),
            content: @json($heroDefaultContent),
        };
        const listEl = document.getElementById('landing-sections-list');
        const addButton = document.getElementById('add-landing-section');
        const template = document.getElementById('landing-section-template');

        if (! listEl || ! addButton || ! template) {
            return;
        }

        const buildName = (index, key) => `landing_sections[${index}][${key}]`;
        let draggingItem = null;

        const bindAttachmentPicker = (item) => {
            const button = item.querySelector('.btn_gallery');

            if (! button || button.dataset.mediaBound === '1' || ! window.jQuery || ! jQuery().rvMedia) {
                return;
            }

            jQuery(button).rvMedia({
                multiple: false,
                filter: 'everything',
                view_in: 'all_media',
                onSelectFiles: (files, $el) => {
                    const attachment = files?.[0];

                    if (! attachment) {
                        return;
                    }

                    const wrapper = $el.closest('.attachment-wrapper');

                    wrapper.find('.attachment-url').val(attachment.url).trigger('change');
                    wrapper.find('.attachment-info').html(
                        `<a href="${attachment.full_url}" target="_blank" title="${attachment.name}">${attachment.url}</a>
                        <small class="d-block">${attachment.size}</small>`
                    );
                    wrapper.find('[data-bb-toggle="media-file-remove"]').show();
                    wrapper.find('.attachment-details').removeClass('hidden');
                },
            });

            button.dataset.mediaBound = '1';
        };

        const updateSectionImageUI = (item, imagePath = '') => {
            const wrapper = item.querySelector('.section-image-wrapper');
            const hiddenInput = item.querySelector('.section-image-input');

            if (! wrapper || ! hiddenInput) {
                return;
            }

            hiddenInput.value = imagePath || '';

            const details = wrapper.querySelector('.attachment-details');
            const info = wrapper.querySelector('.attachment-info');
            const removeButton = wrapper.querySelector('[data-bb-toggle="media-file-remove"]');

            if (! details || ! info || ! removeButton) {
                return;
            }

            if (! imagePath) {
                details.classList.add('hidden');
                removeButton.style.display = 'none';
                info.innerHTML = '';

                return;
            }

            const encoded = String(imagePath).replace(/"/g, '&quot;');
            info.innerHTML = `<a href="${encoded}" target="_blank" title="${encoded}">${encoded}</a>`;
            details.classList.remove('hidden');
            removeButton.style.display = '';
        };

        const reindex = () => {
            [...listEl.querySelectorAll('.landing-section-item')].forEach((item, index) => {
                item.querySelector('.landing-section-index').textContent = `Section ${index + 1}`;
                item.querySelector('.section-type-input').setAttribute('name', buildName(index, 'type'));
                item.querySelector('.section-title-input').setAttribute('name', buildName(index, 'title'));
                item.querySelector('.section-content-input').setAttribute('name', buildName(index, 'content'));
                item.querySelector('.section-kicker-text-input').setAttribute('name', buildName(index, 'kicker_text'));
                item.querySelector('.section-image-input').setAttribute('name', buildName(index, 'image'));
                item.querySelector('.section-kicker-color-input').setAttribute('name', buildName(index, 'kicker_color'));
                item.querySelector('.section-headline-color-input').setAttribute('name', buildName(index, 'headline_color'));
                item.querySelector('.section-subheadline-color-input').setAttribute('name', buildName(index, 'subheadline_color'));
                item.querySelector('.section-backdrop-color-input').setAttribute('name', buildName(index, 'backdrop_color'));
                item.querySelector('.section-backdrop-opacity-input').setAttribute('name', buildName(index, 'backdrop_opacity'));
                item.querySelector('.section-button-text-input').setAttribute('name', buildName(index, 'button_text'));
                item.querySelector('.section-button-url-input').setAttribute('name', buildName(index, 'button_url'));
            });
        };

        const getDragAfterElement = (container, y) => {
            const draggableElements = [...container.querySelectorAll('.landing-section-item:not(.dragging)')];

            return draggableElements.reduce((closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset, element: child };
                }

                return closest;
            }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
        };

        const addSection = (section = {}) => {
            const fragment = template.content.cloneNode(true);
            const item = fragment.querySelector('.landing-section-item');
            const sectionType = section.type || 'custom_text';
            const isHeroV2 = sectionType === 'hero_section_v2';

            item.querySelector('.section-type-input').value = sectionType;
            item.querySelector('.section-title-input').value = (section.title || (isHeroV2 ? heroDefaults.title : ''));
            item.querySelector('.section-content-input').value = (section.content || (isHeroV2 ? heroDefaults.content : ''));
            item.querySelector('.section-kicker-text-input').value = (section.kicker_text || (isHeroV2 ? heroDefaults.kicker_text : ''));
            item.querySelector('.section-button-text-input').value = section.button_text || '';
            item.querySelector('.section-button-url-input').value = section.button_url || '';
            const fallbackTextColor = section.text_color || '#ffffff';
            item.querySelector('.section-kicker-color-input').value = section.kicker_color || fallbackTextColor;
            item.querySelector('.section-headline-color-input').value = section.headline_color || fallbackTextColor;
            item.querySelector('.section-subheadline-color-input').value = section.subheadline_color || fallbackTextColor;
            item.querySelector('.section-backdrop-color-input').value = section.backdrop_color || '#000000';
            item.querySelector('.section-backdrop-opacity-input').value = section.backdrop_opacity ?? '';
            updateSectionImageUI(item, section.image || '');

            item.querySelector('.remove-landing-section').addEventListener('click', () => {
                item.remove();
                reindex();
            });

            item.querySelector('.drag-handle').addEventListener('mousedown', () => {
                item.setAttribute('draggable', 'true');
            });

            item.addEventListener('dragstart', (event) => {
                draggingItem = item;
                item.classList.add('dragging');
                event.dataTransfer.effectAllowed = 'move';
                event.dataTransfer.setData('text/plain', '');
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
                draggingItem = null;
                reindex();
            });

            listEl.appendChild(item);
            bindAttachmentPicker(item);
            reindex();
        };

        listEl.addEventListener('dragover', (event) => {
            event.preventDefault();
            event.dataTransfer.dropEffect = 'move';

            if (! draggingItem) {
                return;
            }

            const afterElement = getDragAfterElement(listEl, event.clientY);

            if (! afterElement) {
                listEl.appendChild(draggingItem);
            } else {
                listEl.insertBefore(draggingItem, afterElement);
            }
        });

        if (Array.isArray(initialSections) && initialSections.length > 0) {
            initialSections.forEach(section => addSection(section));
        } else {
            addSection({
                type: 'hero_section_v2',
                kicker_text: heroDefaults.kicker_text,
                title: heroDefaults.title,
                content: heroDefaults.content,
            });
            addSection({ type: 'primary_cta', title: 'Get Started Now' });
            addSection({ type: 'trust_indicators', title: 'Trusted by Professionals' });
            addSection({ type: 'problem_section', title: 'Common Problems' });
            addSection({ type: 'solution_overview', title: 'Our Solution' });
            addSection({ type: 'key_benefits', title: 'Key Benefits' });
            addSection({ type: 'product_features_specifications', title: 'Features & Specifications' });
            addSection({ type: 'how_it_works', title: 'How It Works' });
            addSection({ type: 'before_after_results', title: 'Before / After Results' });
            addSection({ type: 'video_demo', title: 'Live Demonstration' });
            addSection({ type: 'testimonials_reviews', title: 'Customer Reviews' });
            addSection({ type: 'comparison', title: 'Why Rubyshop' });
            addSection({ type: 'use_cases', title: 'Who It’s For' });
            addSection({ type: 'pricing_offer', title: 'Pricing & Offer' });
            addSection({ type: 'risk_reversal', title: 'Warranty & Guarantee' });
            addSection({ type: 'faq_section', title: 'FAQ' });
            addSection({ type: 'secondary_cta', title: 'Need More Details?' });
            addSection({ type: 'urgency_scarcity', title: 'Limited Time Offer' });
            addSection({ type: 'contact_section', title: 'Contact Us' });
            addSection({ type: 'final_cta', title: 'Ready to Order?' });
            addSection({ type: 'footer_basic_legal', title: 'Legal & Company Info' });
        }

        addButton.addEventListener('click', () => addSection());
    })();
</script>

<style>
    .landing-section-item {
        cursor: move;
    }

    .landing-section-item.dragging {
        opacity: 0.6;
        border: 1px dashed #e11d48;
    }
</style>
