{{--
    Author: Isabella Cadavid Posada
    Date: 2026-11-04
    Description: Accessible native language dropdown with decorative flags and POST forms.
--}}

<div class="language-selector">
    <details class="language-dropdown">
        <summary
            class="language-dropdown-toggle"
            title="{{ __('general.language_label') }}"
        >
            <span>{{ strtoupper(app()->getLocale()) }}</span>

            <span class="visually-hidden">
                {{ __('general.language_label') }}:
                {{ __('general.language_native') }}
            </span>

            <span class="language-dropdown-arrow" aria-hidden="true">▾</span>
        </summary>

        <div class="language-dropdown-menu">
            <p class="language-dropdown-heading">
                {{ __('general.language_label') }}
            </p>

            @foreach (config('localization.supported', []) as $locale => $label)
                <form
                    action="{{ route('locale.switch', ['lang' => $locale]) }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="language-dropdown-option"
                        title="{{ __($label) }}"
                        @if (app()->getLocale() === $locale)
                            aria-current="true"
                        @endif
                    >
                        <span class="language-option-name">
                            <span class="fw-bold me-2">{{ strtoupper($locale) }}</span>
                            <span lang="{{ $locale }}">
                                {{ __('general.language_native', [], $locale) }}
                            </span>
                        </span>

                        @if (app()->getLocale() === $locale)
                            <span aria-hidden="true">✓</span>
                        @endif
                    </button>
                </form>
            @endforeach
        </div>
    </details>
</div>
