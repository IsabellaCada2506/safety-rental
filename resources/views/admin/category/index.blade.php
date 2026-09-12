{{--
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: Admin view for listing and managing vehicle categories.
--}}

@extends('layouts.app')

@section('content')
<section class="admin-page">
    <div
        class="admin-page-shape admin-page-shape-left"
        aria-hidden="true"
    ></div>

    <div
        class="admin-page-shape admin-page-shape-right"
        aria-hidden="true"
    ></div>

    <div class="container admin-container">
        <header class="admin-header">
            <div>
                <span class="admin-eyebrow">
                    {{ __('category.admin_area') }}
                </span>

                <h1 class="admin-title">
                    {{ __('category.heading_management') }}
                </h1>

                <p class="admin-subtitle">
                    {{ __('category.registered_categories') }}
                </p>
            </div>

            <a
                class="admin-index-create-btn"
                href="{{ route('admin.category.create') }}"
            >
                <span class="admin-index-create-icon" aria-hidden="true">+</span>
                <span>{{ __('category.btn_create') }}</span>
            </a>
        </header>

        @if (session('success'))
            <div
                class="alert alert-success admin-alert"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-danger admin-alert"
                role="alert"
            >
                {{ session('error') }}
            </div>
        @endif

        <div class="admin-index-table-wrapper">
            <table class="admin-index-table">
                <thead>
                    <tr>
                        <th>{{ __('category.id') }}</th>
                        <th>{{ __('category.model') }}</th>
                        <th>{{ __('category.brand') }}</th>
                        <th>{{ __('category.type') }}</th>
                        <th class="text-center">{{ __('category.passenger_capacity') }}</th>
                        <th class="text-center">{{ __('category.luggage_capacity') }}</th>
                        <th class="text-center">{{ __('category.cars_count') }}</th>
                        <th class="text-center">{{ __('category.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($viewData['categories'] as $category)
                        <tr>
                            <td class="admin-index-id">#{{ $category->getId() }}</td>
                            <td class="admin-index-strong">{{ $category->getModel() }}</td>
                            <td>{{ $category->getBrand() }}</td>
                            <td>
                                <span class="admin-index-type-badge">{{ $category->getType() }}</span>
                            </td>
                            <td class="text-center">{{ $category->getPassengerCapacity() }}</td>
                            <td class="text-center">{{ $category->getLuggageCapacity() }}</td>
                            <td class="text-center">
                                <span class="admin-index-status-badge">{{ $category->getCarsCount() }}</span>
                            </td>
                            <td class="text-center">
                                <a
                                    href="{{ route('admin.category.edit', ['id' => $category->getId()]) }}"
                                    class="admin-index-btn admin-index-btn-edit"
                                >
                                    {{ __('category.btn_edit') }}
                                </a>
                                <form
                                    action="{{ route('admin.category.delete', ['id' => $category->getId()]) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="admin-index-btn admin-index-btn-danger"
                                        onclick="return confirm('{{ __('category.confirm_delete') }}')"
                                    >
                                        {{ __('category.btn_delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-index-empty">
                                {{ __('category.no_categories_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

