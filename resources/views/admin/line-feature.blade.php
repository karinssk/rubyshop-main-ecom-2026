@extends(BaseHelper::getAdminMasterLayoutTemplate())

@php
    $config = $pageData['config'];
    $features = $pageData['features'];
    $stats = $pageData['stats'];
    $quickLinks = $pageData['quick_links'];
@endphp

@section('content')
    <div class="row row-cards">
        <div class="col-12">
            <div class="card line-feature-hero border-0">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-start g-3 g-xl-4">
                        <div class="col-xl-7">
                            <span class="badge bg-success-lt text-success mb-3">LINE Feature</span>
                            <h2 class="mb-3 text-white">LINE notification overview</h2>
                            <p class="mb-0 text-white text-opacity-75">
                                This page summarizes the LINE notification setup used by the contact form and
                                customer checkout order flow.
                            </p>
                        </div>
                        <div class="col-xl-5">
                            <div class="line-feature-panel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-uppercase small fw-bold text-muted">Configuration Health</span>
                                    @php
                                        $isReady = $config['user_id_configured'] && $config['channel_secret_configured'] && $config['access_token_configured'];
                                    @endphp
                                    <span class="badge {{ $isReady ? 'bg-success' : 'bg-danger' }}">
                                        {{ $isReady ? 'Ready' : 'Incomplete' }}
                                    </span>
                                </div>
                                <div class="d-grid gap-2 small">
                                    <div class="line-feature-meta">
                                        <span>User ID</span>
                                        <strong title="{{ $config['user_id'] }}">{{ $config['user_id'] }}</strong>
                                    </div>
                                    <div class="line-feature-meta">
                                        <span>Channel Secret</span>
                                        <strong title="{{ $config['channel_secret'] }}">{{ $config['channel_secret'] }}</strong>
                                    </div>
                                    <div class="line-feature-meta">
                                        <span>Access Token</span>
                                        <strong title="{{ $config['access_token'] }}">{{ $config['access_token'] }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($features as $feature)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="card-title mb-0">{{ $feature['title'] }}</h3>
                            <span class="badge {{ $feature['status'] ? 'bg-success-lt text-success' : 'bg-danger-lt text-danger' }}">
                                {{ $feature['status'] ? 'Active' : 'Missing config' }}
                            </span>
                        </div>
                        <p class="text-secondary mb-4">{{ $feature['description'] }}</p>

                        @if ($feature['link'])
                            <a href="{{ $feature['link'] }}" class="btn btn-outline-primary btn-sm">
                                Open
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Activity Snapshot</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="line-feature-stat">
                                <span class="line-feature-stat-label">Contacts</span>
                                <strong>{{ number_format($stats['contacts']['count']) }}</strong>
                                <small>
                                    @if ($stats['contacts']['enabled'] && $stats['contacts']['latest_at'])
                                        Latest: {{ \Carbon\Carbon::parse($stats['contacts']['latest_at'])->format('Y-m-d H:i') }}
                                    @elseif ($stats['contacts']['enabled'])
                                        No data yet
                                    @else
                                        Plugin unavailable
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="line-feature-stat">
                                <span class="line-feature-stat-label">Orders</span>
                                <strong>{{ number_format($stats['orders']['count']) }}</strong>
                                <small>
                                    @if ($stats['orders']['enabled'] && $stats['orders']['latest_at'])
                                        Latest: {{ \Carbon\Carbon::parse($stats['orders']['latest_at'])->format('Y-m-d H:i') }}
                                    @elseif ($stats['orders']['enabled'])
                                        No data yet
                                    @else
                                        Plugin unavailable
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Quick Links</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        @foreach ($quickLinks as $link)
                            <a href="{{ $link['url'] }}" class="line-feature-link">
                                <div>
                                    <div class="fw-semibold text-body">{{ $link['label'] }}</div>
                                    <div class="text-secondary small">{{ $link['description'] }}</div>
                                </div>
                                <span class="badge bg-primary-lt text-primary">Open</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('header')
    <style>
        .line-feature-hero {
            background:
                radial-gradient(circle at top left, rgba(6, 182, 212, 0.25), transparent 28%),
                linear-gradient(135deg, #0f172a 0%, #111827 45%, #164e63 100%);
            overflow: hidden;
        }

        .line-feature-panel {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 1rem;
            margin-left: auto;
            max-width: 26rem;
            padding: 1rem;
            width: 100%;
        }

        .line-feature-meta {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            display: grid;
            gap: 0.5rem;
            grid-template-columns: minmax(0, 7rem) minmax(0, 1fr);
            padding: 0.75rem 0.875rem;
        }

        .line-feature-meta span {
            color: #6b7280;
            line-height: 1.4;
        }

        .line-feature-meta strong {
            color: #111827;
            display: block;
            font-size: 0.875rem;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .line-feature-stat {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
            min-height: 100%;
            padding: 1rem;
        }

        .line-feature-stat-label {
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .line-feature-stat strong {
            color: #0f172a;
            font-size: 1.75rem;
            line-height: 1;
        }

        .line-feature-stat small {
            color: #64748b;
        }

        .line-feature-link {
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 0.875rem;
            display: flex;
            justify-content: space-between;
            padding: 0.875rem 1rem;
            text-decoration: none;
            transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .line-feature-link:hover {
            border-color: #60a5fa;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
            transform: translateY(-1px);
        }

        @media (max-width: 991.98px) {
            .line-feature-panel {
                margin-left: 0;
                max-width: none;
            }
        }
    </style>
@endpush
