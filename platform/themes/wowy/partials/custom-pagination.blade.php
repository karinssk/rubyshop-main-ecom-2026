@if ($paginator->hasPages())
    @php
        $appendQueryValue = function (array &$segments, string $key, $value) use (&$appendQueryValue): void {
            if ($value === null || $value === '') {
                return;
            }

            if (is_array($value)) {
                $isList = array_keys($value) === range(0, count($value) - 1);

                foreach ($value as $nestedKey => $nestedValue) {
                    $appendQueryValue(
                        $segments,
                        $isList ? $key . '[]' : $key . '[' . $nestedKey . ']',
                        $nestedValue
                    );
                }

                return;
            }

            $segments[] = str_replace(['%5B', '%5D'], ['[', ']'], rawurlencode($key)) . '=' . rawurlencode((string) $value);
        };

        $paginationUrl = function (int $page) use ($paginator, $appendQueryValue): string {
            $query = request()->query();
            $pageName = $paginator->getPageName();

            if ($page <= 1) {
                unset($query[$pageName]);
            } else {
                $query[$pageName] = $page;
            }

            $segments = [];

            foreach ($query as $key => $value) {
                $appendQueryValue($segments, (string) $key, $value);
            }

            return $paginator->path() . ($segments ? '?' . implode('&', $segments) : '');
        };
    @endphp

    <div class="pagination-area mt-15 mb-md-5 mb-lg-0 pagination-page">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                @if (!$paginator->onFirstPage())
                    <li class="page-item">
                        <a class="prev page-link" href="{{ $paginationUrl($paginator->currentPage() - 1) }}" rel="prev"><i class="fa fa-angle-left"></i></a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="page-item">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $paginationUrl((int) $page) }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item"><a class="next page-link" href="{{ $paginationUrl($paginator->currentPage() + 1) }}" rel="next"><i class="fa fa-angle-right"></i></a></li>
                @endif
            </ul>
        </nav>
    </div>
@endif
