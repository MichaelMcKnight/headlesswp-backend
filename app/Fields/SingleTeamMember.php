<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SingleTeamMember extends Field
{

    public function locations(): array
    {
        $args = [
            'post_type'         =>  'locations',
            'posts_per_page'    =>  -1,
            'orderby'           =>  'title',
            'order'             =>  'ASC',
            'post_status'       =>  'publish',
        ];

        $query = new \WP_Query($args);
        $locations = [];

        if($query->have_posts()) {
            while($query->have_posts()) {
                $query->the_post();
                $title = get_the_title();
                $locations[] = $title;
            }
        }

        return $locations;
    }

    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('single_team_member');

        $fields
            ->setLocation('post_type', '==', 'team-members');

        $fields
            ->addTrueFalse('leadership', [
                'instructions'  =>  'Is this team member in leadership?',
                'wrapper'       =>  ['width' => '50%'],
            ])
            ->addText('job_title', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addSelect('department', [
                'choices'   =>  [
                    'Creative',
                    'Marketing',
                    'Web',
                    'Operations',
                ],
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addSelect('locations', [
                'choices'   =>  $this->locations(),
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addWysiwyg('bio');

        return $fields->build();
    }
}
