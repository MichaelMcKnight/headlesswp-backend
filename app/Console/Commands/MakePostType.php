<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakePostType extends Command
{
    protected $name = 'make:PostType';
    protected $description = 'Create a new custom post type class';

    public function handle()
    {
        $input = $this->argument('name');

        $singular = Str::singular(Str::headline($input));
        $plural = Str::plural($singular);
        $name = Str::studly($plural);
        $slug = Str::slug($plural);

        $directory = app_path('PostTypes');
        $path = "{$directory}/{$name}.php";

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (file_exists($path)) {
            $this->components->error("PostType {$name} already exists.");
            return;
        }

        file_put_contents($path, $this->getStub($name, $slug, $singular, $plural));

        $relativePath = str_replace(base_path() . '/', '', $path);

        $this->components->info("PostType {$name} successfully created.");
        $this->line("     ⮑  {$relativePath}");
    }

    protected function getStub(string $name, string $slug, string $label, string $labelPlural): string
    {
        return <<<PHP
        <?php

        namespace App\PostTypes;

        class {$name}
        {
            public static function register(): void
            {
                \$labels = [
                    'name'                  => '{$labelPlural}',
                    'singular_name'         => '{$label}',
                    'menu_name'             => '{$labelPlural}',
                    'name_admin_bar'        => '{$label}',
                    'archives'              => '{$label} Archives',
                    'attributes'            => '{$label} Attributes',
                    'parent_item_colon'     => 'Parent {$label}:',
                    'all_items'             => 'All {$labelPlural}',
                    'add_new_item'          => 'Add New {$label}',
                    'add_new'               => 'Add New',
                    'new_item'              => 'New {$label}',
                    'edit_item'             => 'Edit {$label}',
                    'update_item'           => 'Update {$label}',
                    'view_item'             => 'View {$label}',
                    'view_items'            => 'View {$labelPlural}',
                    'search_items'          => 'Search {$label}',
                    'not_found'             => 'Not found',
                    'not_found_in_trash'    => 'Not found in Trash',
                    'featured_image'        => 'Featured Image',
                    'set_featured_image'    => 'Set featured image',
                    'remove_featured_image' => 'Remove featured image',
                    'use_featured_image'    => 'Use as featured image',
                    'insert_into_item'      => 'Insert into {$label}',
                    'uploaded_to_this_item' => 'Uploaded to this {$label}',
                    'items_list'            => '{$labelPlural} list',
                    'items_list_navigation' => '{$labelPlural} list navigation',
                    'filter_items_list'     => 'Filter {$labelPlural} list',
                ];

                \$args = [
                    'label'                 => '{$label}',
                    'description'           => '{$label} Type',
                    'labels'                => \$labels,
                    'supports'              => ['title', 'editor', 'custom-fields', 'revisions', 'thumbnail'],
                    'hierarchical'          => false,
                    'public'                => true,
                    'show_ui'               => true,
                    'show_in_menu'          => true,
                    'menu_position'         => 20,
                    'menu_icon'             => 'dashicons-welcome-write-blog',
                    'show_in_admin_bar'     => true,
                    'show_in_nav_menus'     => true,
                    'can_export'            => true,
                    'has_archive'           => true,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'capability_type'       => 'page',
                    'show_in_rest'          => true,
                ];

                register_post_type('{$slug}', \$args);
            }
        }
        PHP;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the post type.'],
        ];
    }
}
