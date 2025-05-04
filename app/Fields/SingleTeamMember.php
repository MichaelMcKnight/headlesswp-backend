<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SingleTeamMember extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('single_team_member');

        $fields
            ->setLocation('post_type', '==', 'team-members');

        $fields
            ->addText('job_title', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addEmail('email', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addWysiwyg('bio');

        return $fields->build();
    }
}
