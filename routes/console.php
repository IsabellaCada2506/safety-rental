<?php

/**
 * Author: Isabella Cadavid Posada
 * Author: Isabella Ocampo
 * Author: Alejandro Correa Marin
 * Author: Wendy Atehortua
 * Date: 2026-09-15
 * Description: Console routes for Artisan CLI commands.
 */

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
