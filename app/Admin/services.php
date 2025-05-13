<?php

// Update admin columns
add_filter( 'manage_services_posts_columns', 'service_posts_columns' );
function service_posts_columns( $columns ) {
    $columns = [
        'cb' => $columns['cb'],
        'title' => __( 'Name', $textDomain ),
        'service_type' => __( 'Service Type', $textDomain ),
        'date' => __( 'Date' ),
    ];
    return $columns;
}

add_action( 'manage_services_posts_custom_column', 'service_custom_column', 10, 2 );
function service_custom_column( $column, $post_id ) {
    if ( 'service_type' === $column ) {
        $service_type = get_post_meta( $post_id, 'service_type', true );
        echo $service_type ? esc_html( $service_type ) : __( 'Select Service Type.', 'text-domain' );
    }
}

add_filter( 'manage_edit-services_sortable_columns', 'service_sortable_columns' );
function service_sortable_columns( $columns ) {
    $columns['service_type'] = 'service_type';
    return $columns;
}

add_action( 'pre_get_posts', 'service_column_orderby' );
function service_column_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    if ( 'service_type' === $orderby ) {
        $query->set( 'meta_key', 'service_type' );
        $query->set( 'orderby', 'meta_value' );
    }
}