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
        <div class="integration-partners">
            @foreach ($viewData['partner']['items'] as $item)
                <article class="integration-card">
                    <dl class="integration-fields">
                        @foreach ($item as $field => $value)
                            <dt>{{ $field }}</dt>

                            <dd>
                                @if (is_array($value))
                                    {{ json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}
                                @elseif (is_bool($value))
                                    {{ $value ? __('integrations.yes') : __('integrations.no') }}
                                @else
                                    {{ $value }}
                                @endif
                            </dd>
                        @endforeach
                    </dl>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection