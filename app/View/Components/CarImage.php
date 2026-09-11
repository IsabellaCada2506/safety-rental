<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-10
 * Description: Blade component that resolves the display URL for a car image, falling back to the default placeholder when no image is set.
 */

namespace App\View\Components;

use App\Utils\ImageUrlResolver;
use Illuminate\View\Component;
use Illuminate\View\View;

class CarImage extends Component
{
    private string $url;

    private string $alt;

    public function __construct(?string $image = null, ?string $alt = null)
    {
        $this->url = ImageUrlResolver::resolve($image);
        $this->alt = $alt ?? __('car.image_alt');
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function render(): View
    {
        $viewData = [];
        $viewData['url'] = $this->getUrl();
        $viewData['alt'] = $this->getAlt();

        return view('components.car-image', ['viewData' => $viewData]);
    }
}
