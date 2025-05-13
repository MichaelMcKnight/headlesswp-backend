<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeTaxonomy extends Command
{
    protected $name = 'make:taxonomy';
    protected $description = 'Create a new taxonomy class';

    public function handle()
    {
        $input = $this->argument('name');

        $singular = Str::singular(Str::headline($input));
        $plural = Str::plural($singular);
        $name = Str::studly($plural);
        $slug = Str::slug($plural);

        $directory = app_path('Taxonomies');
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

        $this->components->info("Taxonomy {$name} successfully created.");
        $this->line("     ⮑  {$relativePath}");
    }

    protected function getStub(string $name, string $slug, string $label, string $labelPlural): string
    {
        return <<<PHP
        <?php

        namespace App\Taxonomies;

        class {$name}
        {
            public static function register(): void
            {
                \$labels = [
                    'name'                       => '{$labelPlural}',
                    'singular_name'              => '{$label}',
                    'menu_name'                  => '{$labelPlural}',
                    'all_items'                  => 'All {$labelPlural}',
                    'parent_item'                => 'Parent {$label}',
                    'parent_item_colon'          => 'Parent {$label}:',
                    'new_item_name'              => 'New {$label} Name',
                    'add_new_item'               => 'Add New {$label}',
                    'edit_item'                  => 'Edit {$label}',
                    'update_item'                => 'Update {$label}',
                    'view_item'                  => 'View {$label}',
                    'separate_items_with_commas' => 'Separate {$labelPlural} with commas',
                    'add_or_remove_items'        => 'Add or remove {$labelPlural}',
                    'choose_from_most_used'      => 'Choose from the most used',
                    'popular_items'              => 'Popular {$labelPlural}',
                    'search_items'               => 'Search {$labelPlural}',
                    'not_found'                  => 'Not Found',
                    'no_terms'                   => 'No {$labelPlural}',
                    'items_list'                 => '{$labelPlural} list',
                    'items_list_navigation'      => '{$labelPlural} list navigation',
                ];

                \$rewrite = [
                    'slug'         => '{$slug}',
                    'with_front'   => false,
                    'hierarchical' => false,
                ];

                \$args = [
                    'labels'             => \$labels,
                    'hierarchical'       => true,
                    'public'             => true,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'show_in_nav_menus' => true,
                    'show_tagcloud'     => true,
                    'rewrite'           => \$rewrite,
                    'show_in_rest'      => true,
                ];

                register_taxonomy('{$slug}', ['post'], \$args);
            }
        }
        PHP;
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the taxonomy.'],
        ];
    }
}
