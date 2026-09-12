{{--
    Author: Alejandro Correa Marin
    Date: 2026-09-12
    Description: Admin index listing registered users with edit and delete actions.
--}}

@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div class="admin-page-shape admin-page-shape-left" aria-hidden="true"></div>
    <div class="admin-page-shape admin-page-shape-right" aria-hidden="true"></div>

    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('car.admin_area') }}
                </span>
                <h1 class="admin-title">
                    {{ $viewData['title'] }}
                </h1>
                <p class="admin-subtitle">
                    {{ __('user.subtitle') }}
                </p>
            </div>

            <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                &larr; {{ __('authentication.dashboard') }}
            </a>
        </header>

        @if (session('success'))
            <div class="alert alert-success admin-alert" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger admin-alert" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="admin-index-table-wrapper">
            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>{{ __('user.name') }}</th>
                        <th>{{ __('user.last_name') }}</th>
                        <th>{{ __('user.email') }}</th>
                        <th>{{ __('user.role') }}</th>
                        <th>{{ __('user.reservations') }}</th>
                        <th class="text-center">{{ __('user.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['users'] as $user)
                        <tr>
                            <td>{{ $user->getName() }}</td>
                            <td>{{ $user->getLastName() }}</td>
                            <td>{{ $user->getEmail() }}</td>
                            <td>
                                <span class="admin-index-type-badge">
                                    {{ $user->isAdmin() ? __('user.role_admin') : __('user.role_customer') }}
                                </span>
                            </td>
                            <td>
                                <span class="admin-index-status-badge">{{ $user->getReservationsCount() }}</span>
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{ route('admin.user.edit', ['id' => $user->getId()]) }}"
                                    class="admin-index-btn admin-index-btn-edit"
                                >
                                    {{ __('user.btn_edit') }}
                                </a>
                                <form
                                    action="{{ route('admin.user.delete', ['id' => $user->getId()]) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="admin-index-btn admin-index-btn-danger"
                                        onclick="return confirm('{{ __('user.confirm_delete') }}')"
                                    >
                                        {{ __('user.btn_delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="admin-index-empty">
                                {{ __('user.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
