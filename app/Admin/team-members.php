<?php

// Update admin columns
add_filter( 'manage_team-members_posts_columns', 'team_member_posts_columns' );
function team_member_posts_columns( $columns ) {
    $columns = [
        'cb' => $columns['cb'],
        'title' => __( 'Name', $textDomain ),
        'leadership' => __( 'Leadership', $textDomain ),
        'job_title' => __( 'Job Title', $textDomain ),
        'department' => __( 'Department', $textDomain ),
        'date' => __( 'Date' ),
    ];
    return $columns;
}

add_action( 'manage_team-members_posts_custom_column', 'team_member_custom_column', 10, 2 );
function team_member_custom_column( $column, $post_id ) {
    if ( 'leadership' === $column ) {
        $leadership = get_post_meta( $post_id, 'leadership', true );
        echo $leadership ? __( 'Yes', 'text-domain' ) : __( 'No', 'text-domain' );
    }

    if ( 'job_title' === $column ) {
        $job_title = get_post_meta( $post_id, 'job_title', true );
        echo $job_title ? esc_html( $job_title ) : __( 'Add Job Title.', 'text-domain' );
    }

    if ( 'department' === $column ) {
        $department = get_post_meta( $post_id, 'department', true );
        echo $department ? esc_html( $department ) : __( 'Select Department.', 'text-domain' );
    }
}

add_filter( 'manage_edit-team-members_sortable_columns', 'team_member_sortable_columns' );
function team_member_sortable_columns( $columns ) {
    $columns['leadership'] = 'leadership';
    $columns['job_title'] = 'job_title';
    $columns['department'] = 'department';
    return $columns;
}

add_action( 'pre_get_posts', 'team_member_column_orderby' );
function team_member_column_orderby( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $orderby = $query->get( 'orderby' );

    if ( 'leadership' === $orderby ) {
        $query->set( 'meta_key', 'leadership' );
        $query->set( 'orderby', 'meta_value' );
    }

    if ( 'job_title' === $orderby ) {
        $query->set( 'meta_key', 'job_title' );
        $query->set( 'orderby', 'meta_value' );
    }

    if ( 'department' === $orderby ) {
        $query->set( 'meta_key', 'department' );
        $query->set( 'orderby', 'meta_value' );
    }
}