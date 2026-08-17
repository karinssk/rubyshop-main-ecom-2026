@if (count($pages) > 0)
    <div class="table-responsive">
        <x-core::table>
            <x-core::table.header>
                <x-core::table.header.cell>
                    #
                </x-core::table.header.cell>
                <x-core::table.header.cell>
                    {{ trans('plugins/analytics::analytics.url') }}
                </x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">
                    {{ trans('plugins/analytics::analytics.views') }}
                </x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Users</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Views/User</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Avg. Engagement</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Engagement</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">90% Scroll</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Events</x-core::table.header.cell>
                <x-core::table.header.cell class="text-end">Key Events</x-core::table.header.cell>
            </x-core::table.header>

            <x-core::table.body>
                @foreach ($pages as $page)
                    <x-core::table.body.row>
                        <x-core::table.body.cell>
                            {{ $loop->index + 1 }}
                        </x-core::table.body.cell>
                        <x-core::table.body.cell>
                            <a
                                href="{{ $page['url'] }}"
                                target="_blank"
                            >{{ Str::limit($page['pageTitle']) }} <x-core::icon
                                    name="ti ti-external-link"
                                    size="sm"
                                /></a>
                        </x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">
                            {{ number_format($page['pageViews']) }}
                        </x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['activeUsers']) }}</x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['viewsPerUser'], 2) }}</x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end text-nowrap">
                            {{ sprintf('%d:%02d', intdiv((int) round($page['averageEngagementTime']), 60), (int) round($page['averageEngagementTime']) % 60) }}
                        </x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['engagementRate'] * 100, 1) }}%</x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['scrolledUsers']) }}</x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['eventCount']) }}</x-core::table.body.cell>
                        <x-core::table.body.cell class="text-end">{{ number_format($page['keyEvents']) }}</x-core::table.body.cell>
                    </x-core::table.body.row>
                @endforeach
            </x-core::table.body>
        </x-core::table>
    </div>

    @if (count($sections ?? []) > 0)
        <h4 class="mt-4 mb-3">Section engagement</h4>
        <div class="table-responsive">
            <x-core::table>
                <x-core::table.header>
                    <x-core::table.header.cell>Page</x-core::table.header.cell>
                    <x-core::table.header.cell>Section</x-core::table.header.cell>
                    <x-core::table.header.cell class="text-end">Visits</x-core::table.header.cell>
                    <x-core::table.header.cell class="text-end">Avg. Time</x-core::table.header.cell>
                </x-core::table.header>
                <x-core::table.body>
                    @foreach ($sections as $section)
                        <x-core::table.body.row>
                            <x-core::table.body.cell>{{ $section['pagePath'] }}</x-core::table.body.cell>
                            <x-core::table.body.cell>{{ $section['name'] }}</x-core::table.body.cell>
                            <x-core::table.body.cell class="text-end">{{ number_format($section['views']) }}</x-core::table.body.cell>
                            <x-core::table.body.cell class="text-end text-nowrap">
                                {{ sprintf('%d:%02d', intdiv((int) round($section['averageTime']), 60), (int) round($section['averageTime']) % 60) }}
                            </x-core::table.body.cell>
                        </x-core::table.body.row>
                    @endforeach
                </x-core::table.body>
            </x-core::table>
        </div>
    @endif
@else
    <x-core::empty-state :title="__('No results found')" />
@endif
