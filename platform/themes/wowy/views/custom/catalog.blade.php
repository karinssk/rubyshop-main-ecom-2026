<div class="w-full bg-gray-100 px-2 py-6 md:px-6">
    <header class="mx-auto mb-6 flex max-w-screen-2xl flex-wrap items-center justify-between gap-3 rounded-xl border border-gray-200 bg-white p-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Rubyshop Catalog') }}</h1>
            <p class="text-sm text-gray-500">{{ __('Sectioned viewer - page') }} {{ $page }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($prevPageUrl)
                <a href="{{ $prevPageUrl }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                    {{ __('Previous') }}
                </a>
            @endif

            <a href="{{ $nextPageUrl }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                {{ __('Next') }}
            </a>

            <a href="{{ route('catalog.file') }}" target="_blank" rel="noopener noreferrer" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                {{ __('Open PDF') }}
            </a>
        </div>
    </header>

    <div class="mx-auto max-w-screen-2xl">
        <div id="catalog-status" class="mb-4 text-sm text-gray-600">{{ __('Loading catalog...') }}</div>
        <div id="catalog-pages" class="flex flex-col gap-8"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const statusEl = document.getElementById('catalog-status');
        const container = document.getElementById('catalog-pages');
        const pdfUrl = @json(route('catalog.file'));
        const initialPage = {{ max(1, (int) $page) }};

        function setStatus(message) {
            if (statusEl) {
                statusEl.textContent = message;
            }
        }

        if (! container || ! window.pdfjsLib) {
            setStatus('Unable to initialize catalog renderer.');
            return;
        }

        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        try {
            const pdf = await window.pdfjsLib.getDocument(pdfUrl).promise;
            const renderedPages = new Set();

            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                const sectionId = 'catalog-page-' + pageNumber;

                const section = document.createElement('section');
                section.id = sectionId;
                section.className = 'catalog-page scroll-mt-28 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm';
                section.dataset.page = String(pageNumber);
                section.innerHTML = '' +
                    '<div class="border-b border-gray-200 px-4 py-2 text-sm font-medium text-gray-600">Section ' + pageNumber + '</div>' +
                    '<div class="p-2 md:p-4">' +
                        '<canvas class="catalog-canvas mx-auto block h-auto w-full"></canvas>' +
                    '</div>';

                container.appendChild(section);
            }

            async function renderPage(section) {
                const pageNumber = Number(section.dataset.page);

                if (! pageNumber || renderedPages.has(pageNumber)) {
                    return;
                }

                renderedPages.add(pageNumber);

                const page = await pdf.getPage(pageNumber);
                const canvas = section.querySelector('canvas');

                if (! canvas) {
                    return;
                }

                const context = canvas.getContext('2d');
                const cssWidth = Math.max(320, section.clientWidth - 32);
                const baseViewport = page.getViewport({ scale: 1 });
                const cssScale = cssWidth / baseViewport.width;
                const viewport = page.getViewport({ scale: cssScale });
                const pixelRatio = window.devicePixelRatio || 1;

                canvas.width = Math.floor(viewport.width * pixelRatio);
                canvas.height = Math.floor(viewport.height * pixelRatio);
                canvas.style.width = Math.floor(viewport.width) + 'px';
                canvas.style.height = Math.floor(viewport.height) + 'px';
                context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);

                await page.render({
                    canvasContext: context,
                    viewport,
                }).promise;
            }

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        renderPage(entry.target);
                    }
                });
            }, { rootMargin: '600px 0px' });

            container.querySelectorAll('.catalog-page').forEach(function (section) {
                observer.observe(section);
            });

            const initialSection = container.querySelector('[data-page="' + initialPage + '"]');
            if (initialSection) {
                await renderPage(initialSection);
                initialSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            setStatus('Loaded ' + pdf.numPages + ' pages.');
        } catch (error) {
            console.error(error);
            setStatus('Failed to load catalog. Please use "Open PDF" button.');
        }
    });
</script>
