<?php

namespace App\PostTypes;

class TeamMembers
{
    public static function register(): void
    {
        $labels = [
            'name'                  => 'Team Members',
            'singular_name'         => 'Team Member',
            'menu_name'             => 'Team Members',
            'name_admin_bar'        => 'Team Member',
            'archives'              => 'Team Member Archives',
            'attributes'            => 'Team Member Attributes',
            'parent_item_colon'     => 'Parent Team Member:',
            'all_items'             => 'All Team Members',
            'add_new_item'          => 'Add New Team Member',
            'add_new'               => 'Add New',
            'new_item'              => 'New Team Member',
            'edit_item'             => 'Edit Team Member',
            'update_item'           => 'Update Team Member',
            'view_item'             => 'View Team Member',
            'view_items'            => 'View Team Members',
            'search_items'          => 'Search Team Member',
            'not_found'             => 'Not found',
            'not_found_in_trash'    => 'Not found in Trash',
            'featured_image'        => 'Featured Image',
            'set_featured_image'    => 'Set featured image',
            'remove_featured_image' => 'Remove featured image',
            'use_featured_image'    => 'Use as featured image',
            'insert_into_item'      => 'Insert into Team Member',
            'uploaded_to_this_item' => 'Uploaded to this Team Member',
            'items_list'            => 'Team Members list',
            'items_list_navigation' => 'Team Members list navigation',
            'filter_items_list'     => 'Filter Team Members list',
        ];

        $args = [
            'label'                 => 'Team Member',
            'description'           => 'Team Member Type',
            'labels'                => $labels,
            'supports'              => ['title', 'custom-fields', 'revisions', 'thumbnail'],
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-admin-users',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        ];

        register_post_type('team-members', $args);
    }
}