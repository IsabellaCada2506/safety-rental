<div class="admin-form-grid">
    <div>
        <label for="location-name" class="form-label">
            {{ __('location.name_label') }}
            <span class="admin-form-required">*</span>
        </label>

        <input
            id="location-name"
            name="name"
            type="text"
            maxlength="255"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', ($viewData['location'] ?? null)?->getName()) }}"
            placeholder="{{ __('location.name_placeholder') }}"
            required
            @error('name')
                aria-invalid="true"
                aria-describedby="name-error"
            @enderror
        >

        @error('name')
            <div id="name-error" class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label for="location-city" class="form-label">
            {{ __('location.city_label') }}
            <span class="admin-form-required">*</span>
        </label>

        <input
            id="location-city"
            name="city"
            type="text"
            maxlength="100"
            class="form-control @error('city') is-invalid @enderror"
            value="{{ old('city', ($viewData['location'] ?? null)?->getCity()) }}"
            placeholder="{{ __('location.city_placeholder') }}"
            required
            @error('city')
                aria-invalid="true"
                aria-describedby="city-error"
            @enderror
        >

        @error('city')
            <div id="city-error" class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="admin-form-field-full">
        <label for="location-address" class="form-label">
            {{ __('location.address_label') }}
            <span class="admin-form-required">*</span>
        </label>

        <input
            id="location-address"
            name="address"
            type="text"
            maxlength="255"
            class="form-control @error('address') is-invalid @enderror"
            value="{{ old('address', ($viewData['location'] ?? null)?->getAddress()) }}"
            placeholder="{{ __('location.address_placeholder') }}"
            required
            @error('address')
                aria-invalid="true"
                aria-describedby="address-error"
            @enderror
        >

        @error('address')
            <div id="address-error" class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label for="location-headquarters" class="form-label">
            {{ __('location.headquarters_label') }}
            <span class="admin-form-required">*</span>
        </label>

        <input
            id="location-headquarters"
            name="headquarters"
            type="text"
            maxlength="255"
            class="form-control @error('headquarters') is-invalid @enderror"
            value="{{ old('headquarters', ($viewData['location'] ?? null)?->getHeadquarters()) }}"
            placeholder="{{ __('location.headquarters_placeholder') }}"
            required
            @error('headquarters')
                aria-invalid="true"
                aria-describedby="headquarters-error"
            @enderror
        >

        @error('headquarters')
            <div
                id="headquarters-error"
                class="invalid-feedback d-block"
            >
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <label for="location-telephone" class="form-label">
            {{ __('location.telephone_label') }}
            <span class="admin-form-required">*</span>
        </label>

        <input
            id="location-telephone"
            name="telephone"
            type="tel"
            maxlength="50"
            class="form-control @error('telephone') is-invalid @enderror"
            value="{{ old('telephone', ($viewData['location'] ?? null)?->getTelephone()) }}"
            placeholder="{{ __('location.telephone_placeholder') }}"
            required
            @error('telephone')
                aria-invalid="true"
                aria-describedby="telephone-error"
            @enderror
        >

        @error('telephone')
            <div id="telephone-error" class="invalid-feedback d-block">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="integration-notice my-4">
    {{ __('pickup.admin_help') }}
</div>

@if (isset($viewData['location']))
    <a
        href="https://www.google.com/maps/search/?api=1&query={{ urlencode($viewData['location']->getAddress().', '.$viewData['location']->getCity().', Colombia') }}"
        class="integration-button integration-button-secondary mb-4"
        target="_blank"
        rel="noopener noreferrer"
    >
        {{ __('integrations.open_maps') }}
        <span aria-hidden="true">↗</span>
    </a>
@endif