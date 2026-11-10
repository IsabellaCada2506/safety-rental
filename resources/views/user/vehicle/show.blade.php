@extends('layouts.app')
@section('title', $viewData['title'])
@section('content')
<section class="container py-5">
    <h1>{{ $viewData['car']->getCategory()?->getName() }}</h1>
    <p>{{ $viewData['car']->getDescription() }}</p>
    <p>{{ $viewData['car']->getLocation()?->getName() }} · {{ $viewData['car']->getLocation()?->getAddress() }}</p>
    <p>{{ number_format($viewData['car']->getPrice()) }} COP / {{ __('catalog.per_day') }}</p>
    <a class="btn btn-primary" href="{{ route('catalog.show', ['id' => $viewData['car']->getId()]) }}">{{ __('catalog.rent_now') }}</a>
    <a class="btn btn-outline-primary" href="{{ route('partner.index') }}">{{ __('integrations.partners') }}</a>
</section>
@endsection
