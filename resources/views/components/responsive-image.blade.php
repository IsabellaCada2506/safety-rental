{{--
    Author: Wendy Atehortua
    Date: 2026-11-08
    Description: Generic view component template that renders an image tag with resolved source URL and alt text.
--}}

<img src="{{ $viewData['src'] }}" alt="{{ $viewData['alt'] }}" {{ $attributes }}>

