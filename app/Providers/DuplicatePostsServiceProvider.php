<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DuplicatePostsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        add_filter('post_row_actions', function ($actions, $post) {
            if (!current_user_can('edit_posts')) {
                return $actions;
            }

            $url = wp_nonce_url(
                add_query_arg([
                    'action' => 'rd_duplicate_post_as_draft',
                    'post' => $post->ID,
                ], 'admin.php'),
                basename(__FILE__),
                'duplicate_nonce'
            );

            $actions['duplicate'] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

            return $actions;
        }, 10, 2);
        add_filter('page_row_actions', function ($actions, $post) {
            if (!current_user_can('edit_posts')) {
                return $actions;
            }

            $url = wp_nonce_url(
                add_query_arg([
                    'action' => 'rd_duplicate_post_as_draft',
                    'post' => $post->ID,
                ], 'admin.php'),
                basename(__FILE__),
                'duplicate_nonce'
            );

            $actions['duplicate'] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

            return $actions;
        }, 10, 2);
        add_action('admin_action_rd_duplicate_post_as_draft', function () {
            if (empty($_GET['post'])) {
                wp_die('No post to duplicate has been provided!');
            }

            if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__))) {
                return;
            }

            $post_id = absint($_GET['post']);
            $post = get_post($post_id);

            $new_post_author = wp_get_current_user()->ID;

            if ($post) {
                $args = [
                    'comment_status' => $post->comment_status,
                    'ping_status'    => $post->ping_status,
                    'post_author'    => $new_post_author,
                    'post_content'   => $post->post_content,
                    'post_excerpt'   => $post->post_excerpt,
                    'post_name'      => $post->post_name,
                    'post_parent'    => $post->post_parent,
                    'post_password'  => $post->post_password,
                    'post_status'    => 'draft',
                    'post_title'     => $post->post_title,
                    'post_type'      => $post->post_type,
                    'to_ping'        => $post->to_ping,
                    'menu_order'     => $post->menu_order,
                ];

                $new_post_id = wp_insert_post($args);

                $taxonomies = get_object_taxonomies($post->post_type);
                if ($taxonomies) {
                    foreach ($taxonomies as $taxonomy) {
                        $post_terms = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'slugs']);
                        wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
                    }
                }

                $post_meta = get_post_meta($post_id);
                if ($post_meta) {
                    foreach ($post_meta as $meta_key => $meta_values) {
                        if ($meta_key === '_wp_old_slug') continue;
                        foreach ($meta_values as $meta_value) {
                            add_post_meta($new_post_id, $meta_key, $meta_value);
                        }
                    }
                }

                wp_safe_redirect(add_query_arg([
                    'post_type' => ($post->post_type !== 'post' ? $post->post_type : false),
                    'saved'     => 'post_duplication_created',
                ], admin_url('edit.php')));
                exit;
            } else {
                wp_die('Post creation failed, could not find original post.');
            }
        });
        add_action('admin_notices', function () {
            $screen = get_current_screen();
            if ('edit' !== $screen->base) return;

            if (isset($_GET['saved']) && $_GET['saved'] === 'post_duplication_created') {
                echo '<div class="notice notice-success is-dismissible"><p>Post copy created.</p></div>';
            }
        });
    }
}
