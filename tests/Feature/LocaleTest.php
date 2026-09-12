<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Tests for switching the application locale between English and Spanish.
 */

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_user_can_switch_locale_to_spanish(): void
    {
        $response = $this->get(route('locale.switch', 'es'));

        $response->assertSessionHas('locale', 'es');
        $response->assertRedirect();
    }

    public function test_user_can_switch_locale_to_english(): void
    {
        $response = $this->get(route('locale.switch', 'en'));

        $response->assertSessionHas('locale', 'en');
        $response->assertRedirect();
    }
}
