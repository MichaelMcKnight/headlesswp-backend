<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SingleCareer extends Field
{

    public function locations(): array
    {
        $args = [
            'post_type'         =>  'locations',
            'posts_per_page'    =>  -1,
            'orderby'           =>  'title',
            'order'             =>  'ASC',
        ];

        $query = new \WP_Query($args);

        $locations = [];

        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();

                $page_title = get_the_title();
                $locations[] = $page_title;
            }
        }

        return $locations;
    }

    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('single_career');

        $fields
            ->setLocation('post_type', '==', 'careers');

        $fields
            ->addSelect('employment_type', [
                'choices'   =>  [
                    'Full-time',
                    'Part-time',
                    'Contract',
                    'Internship',
                ],
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addSelect('department', [
                'choices'   =>  [
                    'Creative',
                    'Marketing',
                    'Development',
                    'Operations',
                ],
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addText('salary_range', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addSelect('location', [
                'choices'   =>  $this->locations(),
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addWysiwyg('description');

        return $fields->build();
    }
}
