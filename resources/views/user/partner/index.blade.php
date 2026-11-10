{{--
    Author: Isabella Ocampo
    Author: Isabella Cadavid Posada
    Date: 2026-11-10
    Description: Partner integrations view displaying external team products in a responsive grid.
--}}

@extends('layouts.app')

@section('title', $viewData['title'])

@section('content')
<section class="integration-page">
    <header class="integration-hero">
        <span class="integration-tag">
            {{ __('authentication.application_name') }}
        </span>

        <h1>{{ __('integrations.partners') }}</h1>

        <p>{{ __('integrations.partner_intro') }}</p>
    </header>

    @if ($viewData['partner']['error'])
        <article class="integration-card">
            <div class="integration-notice" role="status">
                {{ __('integrations.'.$viewData['partner']['error']) }}
            </div>
        </article>
    @else
        <div class="partner-products-grid">
            @foreach ($viewData['partner']['items'] as $item)
                @php
                    $id = $item['id'] ?? null;
                    $name = $item['name'] ?? $item['title'] ?? null;
                    $price = $item['price'] ?? null;
                    $description = $item['description'] ?? null;
                    $image = $item['image'] ?? $item['img'] ?? $item['photo'] ?? null;
                    $url = $item['url'] ?? $item['link'] ?? null;
                    $brand = $item['brand'] ?? $item['marca'] ?? null;
                    $category = $item['category'] ?? $item['categoria'] ?? null;
                    $stock = $item['stock'] ?? null;
                @endphp

                <article class="partner-card">
                    @if ($image)
                        <div class="partner-card-media">
                            <img
                                src="{{ $image }}"
                                alt="{{ $name ?? __('general.image_alt') }}"
                                class="partner-card-img"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='https://placehold.co/600x400/e8f0fe/014f86?text=Partner+Product';"
                            >
                            <div class="partner-card-badges">
                                @if ($category)
                                    <span class="partner-badge partner-badge-category">
                                        {{ $category }}
                                    </span>
                                @endif

                                @if ($stock !== null)
                                    <span class="partner-badge {{ (int) $stock > 0 ? 'partner-badge-stock' : 'partner-badge-empty' }}">
                                        {{ (int) $stock > 0 ? __('integrations.stock_available', ['count' => $stock]) : __('integrations.out_of_stock') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="partner-card-body">
                        <div class="partner-card-header">
                            @if ($brand)
                                <span class="partner-card-brand">{{ $brand }}</span>
                            @endif

                            @if (!$image && $category)
                                <span class="partner-badge partner-badge-category ms-auto">
                                    {{ $category }}
                                </span>
                            @endif
                        </div>

                        <h3 class="partner-card-title">
                            {{ $name ?? __('integrations.partner_item_fallback', ['id' => $id ?? '']) }}
                        </h3>

                        @if ($description)
                            <p class="partner-card-desc">
                                {{ \Illuminate\Support\Str::limit($description, 120) }}
                            </p>
                        @endif

                        @if ($price !== null)
                            <div class="partner-card-price-row">
                                <span class="partner-card-price-label">{{ __('integrations.partner_price') }}</span>
                                <span class="partner-card-price">
                                    ${{ is_numeric($price) ? number_format((float) $price, 2) : $price }}
                                </span>
                            </div>
                        @endif

                        @if (!$image && $stock !== null)
                            <div class="mb-3">
                                <span class="partner-badge {{ (int) $stock > 0 ? 'partner-badge-stock' : 'partner-badge-empty' }}">
                                    {{ (int) $stock > 0 ? __('integrations.stock_available', ['count' => $stock]) : __('integrations.out_of_stock') }}
                                </span>
                            </div>
                        @endif

                        @if ($url)
                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="partner-card-btn"
                            >
                                <span>{{ __('integrations.view_product') }}</span>
                                <svg class="partner-btn-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        @if ($viewData['partner']['items']->hasPages())
            <div class="d-flex justify-content-center mt-5 mb-4">
                {{ $viewData['partner']['items']->links() }}
            </div>
        @endif
    @endif
</section>
@endsection