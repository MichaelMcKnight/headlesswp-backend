<?php

namespace App\PostTypes;

class Locations
{
    public static function register(): void
    {
        $labels = [
            'name'                  => 'Locations',
            'singular_name'         => 'Location',
            'menu_name'             => 'Locations',
            'name_admin_bar'        => 'Location',
            'archives'              => 'Location Archives',
            'attributes'            => 'Location Attributes',
            'parent_item_colon'     => 'Parent Location:',
            'all_items'             => 'All Locations',
            'add_new_item'          => 'Add New Location',
            'add_new'               => 'Add New',
            'new_item'              => 'New Location',
            'edit_item'             => 'Edit Location',
            'update_item'           => 'Update Location',
            'view_item'             => 'View Location',
            'view_items'            => 'View Locations',
            'search_items'          => 'Search Location',
            'not_found'             => 'Not found',
            'not_found_in_trash'    => 'Not found in Trash',
            'featured_image'        => 'Featured Image',
            'set_featured_image'    => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image'    => 'Use as featured image',
            'insert_into_item'      => 'Insert into Location',
            'uploaded_to_this_item' => 'Uploaded to this Location',
            'items_list'            => 'Locations list',
            'items_list_navigation' => 'Locations list navigation',
            'filter_items_list'     => 'Filter Locations list',
        ];

        $args = [
            'label'                 => 'Location',
            'description'           => 'Location Type',
            'labels'                => $labels,
            'supports'              => ['title', 'custom-fields', 'revisions', 'thumbnail'],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-location',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        ];

        register_post_type('locations', $args);
    }
}