<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SingleLocation extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('single_location');

        $fields
            ->setLocation('post_type', '==', 'locations');

        $fields
            ->addTextarea('address', [
                'rows'      =>  3,
                'new_lines' =>  'br',
                'wrapper'   =>  ['width' => '60%'],
            ])
            ->addGoogleMap('map', [
                'wrapper'   =>  ['width' => '40%'],
            ])
            ->addText('phone', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addEmail('email', [
                'wrapper'   =>  ['width' => '50%'],
            ])
            ->addWysiwyg('description');

        return $fields->build();
    }
}
