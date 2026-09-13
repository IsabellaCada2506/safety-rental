<?php

/**
 * Author: Wendy Atehortua
 * Date: 2026-09-11
 * Description: Utility responsible for resolving the public URL of a stored
 *              image, falling back to a placeholder asset when no image is
 *              set. Keeps storage/file resolution logic out of the view layer.
 */

namespace App\Utils;

class ImageUrlResolver
{
    public static function resolve(?string $image, string $placeholder = 'images/car-placeholder.png'): string
    {
        if (! $image) {
            return asset($placeholder);
        }

        return str_starts_with($image, 'http')
            ? $image
            : asset('storage/'.$image);
    }
}
