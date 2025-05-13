<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuRestApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('headless/v1', '/menu/(?P<slug>[a-zA-Z0-9-_]+)', [
                'methods' => 'GET',
                'callback' => function ($data) {
                    $locations = get_nav_menu_locations();
                    if (!isset($locations[$data['slug']])) {
                        return new \WP_Error('not_found', 'Menu not found', ['status' => 404]);
                    }

                    $menu = wp_get_nav_menu_object($locations[$data['slug']]);
                    $items = wp_get_nav_menu_items($menu->term_id);

                    // Build nested menu
                    $menu_tree = [];
                    $indexed = [];

                    foreach ($items as $item) {
                        $item->children = [];
                        $indexed[$item->ID] = $item;
                    }

                    foreach ($indexed as $item) {
                        if ($item->menu_item_parent && isset($indexed[$item->menu_item_parent])) {
                            $indexed[$item->menu_item_parent]->children[] = $item;
                        } else {
                            $menu_tree[] = $item;
                        }
                    }

                    return $menu_tree;
                },
                'permission_callback' => '__return_true',
            ]);
        });
    }
}
