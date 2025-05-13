<?php

namespace App;

/**
 * Register Visual Impact Block Category
 *
 * @param   array $block_categories Array of categories for block types.
 *
 * @return array
 */
add_filter( 'block_categories_all', function ( $block_categories ) {
    return array_merge(
        $block_categories,
        [
            [
                'slug'  => 'custom-theme',
                'title' => esc_html__( 'Custom Theme Blocks', 'sage' )
            ]
        ]
    );
} );
