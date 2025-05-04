<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SingleService extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('single_service');

        $fields
            ->setLocation('post_type', '==', 'services');

        $fields
            ->addSelect('service_type', [
                'choices'   =>  [
                    'Creative',
                    'Marketing',
                    'Web'
                ]
            ])
            ->addTextarea('summary')
            ->addWysiwyg('description')
            ->addImage('icon', [
                'wrapper'   =>  ['width' => '20%'],
            ])
            ->addRepeater('feature_list', [
                'wrapper'       =>  ['width' => '80%'],
                'button_label'  =>  'Add List Item',
            ])
                ->addTextarea('feature', [
                    'rows'  =>  3
                ])
            ->endRepeater();

        return $fields->build();
    }
}
