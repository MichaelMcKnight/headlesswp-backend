<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class OptionsRestApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('acf/v3', '/options', [
                'methods' => 'GET',
                'callback' => function () {
                    return [
                        'acf' => get_fields('option'),
                    ];
                },
                'permission_callback' => '__return_true',
            ]);
        });
    }
}
