<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-11-08
 * Description: Generic Blade component that renders an image from a path or external URL, falling back to a default placeholder when absent.
 */

namespace App\View\Components;

use App\Utils\ImageUrlResolver;
use Illuminate\View\Component;
use Illuminate\View\View;

class ResponsiveImage extends Component
{
    private string $src;

    private string $alt;

    public function __construct(
        ?string $src = null,
        ?string $alt = null,
        string $fallback = 'images/placeholder.png'
    ) {
        $this->src = ImageUrlResolver::resolve($src, $fallback);
        $this->alt = $alt ?? __('general.image_alt');
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }

    public function render(): View
    {
        $viewData = [];
        $viewData['src'] = $this->getSrc();
        $viewData['alt'] = $this->getAlt();

        return view('components.responsive-image', ['viewData' => $viewData]);
    }
}
