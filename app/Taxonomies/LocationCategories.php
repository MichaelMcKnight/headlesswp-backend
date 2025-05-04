<?php

namespace App\Taxonomies;

class LocationCategories
{
    public static function register(): void
    {
        $labels = [
            'name'                       => 'Location Categories',
            'singular_name'              => 'Location Category',
            'menu_name'                  => 'Location Categories',
            'all_items'                  => 'All Location Categories',
            'parent_item'                => 'Parent Location Category',
            'parent_item_colon'          => 'Parent Location Category:',
            'new_item_name'              => 'New Location Category Name',
            'add_new_item'               => 'Add New Location Category',
            'edit_item'                  => 'Edit Location Category',
            'update_item'                => 'Update Location Category',
            'view_item'                  => 'View Location Category',
            'separate_items_with_commas' => 'Separate Location Categories with commas',
            'add_or_remove_items'        => 'Add or remove Location Categories',
            'choose_from_most_used'      => 'Choose from the most used',
            'popular_items'              => 'Popular Location Categories',
            'search_items'               => 'Search Location Categories',
            'not_found'                  => 'Not Found',
            'no_terms'                   => 'No Location Categories',
            'items_list'                 => 'Location Categories list',
            'items_list_navigation'      => 'Location Categories list navigation',
        ];

        $rewrite = [
            'slug'         => 'location-categories',
            'with_front'   => false,
            'hierarchical' => false,
        ];

        $args = [
            'labels'             => $labels,
            'hierarchical'       => true,
            'public'             => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'rewrite'           => $rewrite,
            'show_in_rest'      => true,
        ];

        register_taxonomy('location-categories', ['locations'], $args);
    }
}