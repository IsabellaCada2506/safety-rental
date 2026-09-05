{{-- Author: Isabella Cadavid Posada --}}

<div class="profile-edit-sections">
    <section class="profile-edit-card">
        <header class="profile-edit-card-header">
            <span class="profile-edit-card-number">
                01
            </span>

            <div>
                <h2>
                    {{ __('authentication.personal_information') }}
                </h2>

                <p>
                    {{ __('authentication.personal_information_description') }}
                </p>
            </div>
        </header>

        <div class="profile-edit-grid">
            <div class="profile-edit-field">
                <label for="name">
                    {{ __('authentication.first_name') }}
                </label>

                <input
                    id="name"
                    class="@error('name') is-invalid @enderror"
                    name="name"
                    type="text"
                    value="{{ old('name', $viewData['user']->getName()) }}"
                    autocomplete="given-name"
                    required
                    autofocus
                >

                @error('name')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="last_name">
                    {{ __('authentication.last_name') }}
                </label>

                <input
                    id="last_name"
                    class="@error('last_name') is-invalid @enderror"
                    name="last_name"
                    type="text"
                    value="{{ old('last_name', $viewData['user']->getLastName()) }}"
                    autocomplete="family-name"
                    required
                >

                @error('last_name')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="birth_date">
                    {{ __('authentication.birth_date') }}
                </label>

                <input
                    id="birth_date"
                    class="@error('birth_date') is-invalid @enderror"
                    name="birth_date"
                    type="date"
                    value="{{ old('birth_date', $viewData['user']->getBirthDate()?->format('Y-m-d')) }}"
                    required
                >

                @error('birth_date')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="profile-edit-field">
                <label for="identification_number">
                    {{ __('authentication.identification_number') }}
                </label>

                <input
                    id="identification_number"
                    class="@error('identification_number') is-invalid @enderror"
                    name="identification_number"
                    type="number"
                    value="{{ old('identification_number', $viewData['user']->getIdentificationNumber()) }}"
                    required
                >

                @error('identification_number')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="profile-edit-field profile-edit-field-full">
                <label for="email">
                    {{ __('authentication.email') }}
                </label>

                <input
                    id="email"
                    class="@error('email') is-invalid @enderror"
                    name="email"
                    type="email"
                    value="{{ old('email', $viewData['user']->getEmail()) }}"
                    autocomplete="email"
                    required
                >

                @error('email')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="profile-edit-field profile-edit-field-full">
                <label for="address">
                    {{ __('authentication.address') }}
                </label>

                <input
                    id="address"
                    class="@error('address') is-invalid @enderror"
                    name="address"
                    type="text"
                    value="{{ old('address', $viewData['user']->getAddress()) }}"
                    autocomplete="street-address"
                    required
                >

                @error('address')
                    <span class="profile-edit-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>
    </section>

    <div class="profile-edit-secondary-grid">
        <section class="profile-edit-card">
            <header class="profile-edit-card-header">
                <span
                    class="profile-edit-card-number profile-edit-card-number-orange"
                >
                    02
                </span>

                <div>
                    <h2>
                        {{ __('authentication.driving_information') }}
                    </h2>

                    <p>
                        {{ __('authentication.driving_information_description') }}
                    </p>
                </div>
            </header>

            <div class="profile-edit-stack">
                <div class="profile-edit-field">
                    <label for="license_number">
                        {{ __('authentication.driver_license_number') }}
                    </label>

                    <input
                        id="license_number"
                        class="@error('license_number') is-invalid @enderror"
                        name="license_number"
                        type="number"
                        value="{{ old('license_number', $viewData['user']->getLicenseNumber()) }}"
                        required
                    >

                    @error('license_number')
                        <span class="profile-edit-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="profile-edit-field">
                    <label for="eps">
                        {{ __('authentication.health_provider') }}
                    </label>

                    <input
                        id="eps"
                        class="@error('eps') is-invalid @enderror"
                        name="eps"
                        type="text"
                        value="{{ old('eps', $viewData['user']->getEps()) }}"
                        required
                    >

                    @error('eps')
                        <span class="profile-edit-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </section>

        <section class="profile-edit-card">
            <header class="profile-edit-card-header">
                <span
                    class="profile-edit-card-number profile-edit-card-number-gold"
                >
                    03
                </span>

                <div>
                    <h2>
                        {{ __('authentication.emergency_information') }}
                    </h2>

                    <p>
                        {{ __('authentication.emergency_information_description') }}
                    </p>
                </div>
            </header>

            <div class="profile-edit-stack">
                <div class="profile-edit-field">
                    <label for="emergency_contact_name">
                        {{ __('authentication.emergency_contact_first_name') }}
                    </label>

                    <input
                        id="emergency_contact_name"
                        class="@error('emergency_contact_name') is-invalid @enderror"
                        name="emergency_contact_name"
                        type="text"
                        value="{{ old('emergency_contact_name', $viewData['user']->getEmergencyContactName()) }}"
                        required
                    >

                    @error('emergency_contact_name')
                        <span class="profile-edit-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="profile-edit-field">
                    <label for="emergency_contact_last_name">
                        {{ __('authentication.emergency_contact_last_name') }}
                    </label>

                    <input
                        id="emergency_contact_last_name"
                        class="@error('emergency_contact_last_name') is-invalid @enderror"
                        name="emergency_contact_last_name"
                        type="text"
                        value="{{ old('emergency_contact_last_name', $viewData['user']->getEmergencyContactLastName()) }}"
                        required
                    >

                    @error('emergency_contact_last_name')
                        <span class="profile-edit-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="profile-edit-field">
                    <label for="emergency_contact">
                        {{ __('authentication.emergency_contact_phone') }}
                    </label>

                    <input
                        id="emergency_contact"
                        class="@error('emergency_contact') is-invalid @enderror"
                        name="emergency_contact"
                        type="number"
                        value="{{ old('emergency_contact', $viewData['user']->getEmergencyContact()) }}"
                        autocomplete="tel"
                        required
                    >

                    @error('emergency_contact')
                        <span class="profile-edit-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </section>
    </div>
</div>