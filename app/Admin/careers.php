<?php

// Update admin columns
add_filter( 'manage_careers_posts_columns', 'career_posts_columns' );
function career_posts_columns( $columns ) {
    $columns = [
        'cb' => $columns['cb'],
        'title' => __( 'Name', $textDomain ),
        'location' => __( 'Location', $textDomain ),
        'employment_type' => __( 'Employment Type', $textDomain ),
        'department' => __( 'Department', $textDomain ),
        'date' => __( 'Date' ),
    ];
    return $columns;
}

add_action( 'manage_careers_posts_custom_column', 'career_custom_column', 10, 2 );
function career_custom_column( $column, $post_id ) {
    if ( 'location' === $column ) {
        $location = get_post_meta( $post_id, 'location', true );
        echo $location ? esc_html( $location ) : __( 'Select Location.', 'text-domain' );
    }

    if ( 'employment_type' === $column ) {
        $employment_type = get_post_meta( $post_id, 'employment_type', true );
        echo $employment_type ? esc_html( $employment_type ) : __( 'Select Employment Type.', 'text-domain' );
    }

    if ( 'department' === $column ) {
        $department = get_post_meta( $post_id, 'department', true );
        echo $department ? esc_html( $department ) : __( 'Select Department.', 'text-domain' );
    }
}

add_filter( 'manage_edit-careers_sortable_columns', 'career_sortable_columns' );
function career_sortable_columns( $columns ) {
    $columns['location'] = 'location';
    $columns['employment_type'] = 'employment_type';
    $columns['department'] = 'department';
    return $columns;
}

add_action( 'pre_get_posts', 'career_column_orderby' );
function career_column_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    if ( 'location' === $orderby ) {
        $query->set( 'meta_key', 'location' );
        $query->set( 'orderby', 'meta_value' );
    }

    if ( 'employment_type' === $orderby ) {
        $query->set( 'meta_key', 'employment_type' );
        $query->set( 'orderby', 'meta_value' );
    }

    if ( 'department' === $orderby ) {
        $query->set( 'meta_key', 'department' );
        $query->set( 'orderby', 'meta_value' );
    }
}
