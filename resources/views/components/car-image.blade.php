{{--
    Author: Wendy Atehortua
    Date: 2026-09-10
    Description: Renders the resolved car image URL produced by the CarImage view component.
--}}

<img src="{{ $viewData['url'] }}" alt="{{ $viewData['alt'] }}" {{ $attributes }}>
