<?php

namespace App\Options;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Options as Field;

class ThemeSettings extends Field
{
    /**
     * The option page menu name.
     *
     * @var string
     */
    public $name = 'Theme Settings';

    /**
     * The option page document title.
     *
     * @var string
     */
    public $title = 'Theme Settings | Options';

    /**
     * The option page field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('theme_settings');

        $fields
            ->addTab('Global Site Info')
            ->addText('phone', [
                'wrapper'   =>  ['width' => '50%']
            ])
            ->addEmail('email', [
                'wrapper'   =>  ['width' =>  '50%']
            ])
            ->addTextarea('address', [
                'rows'      =>  3,
                'new_lines' =>  'br'
            ])
            ->addText('copyright_text', [
                'instructions'  =>  'Text to be displayed after "© CURRENT_YEAR".'
            ])
            ->addTab('social_media_settings', [
                'instructions' =>   'Add social media links here. If left blank the social media icon for that network will not appear on the frontend.'
            ])
            ->addUrl('Facebook', [
                'wrapper'   =>  ['width' => '50%']
            ])
            ->addUrl('X/Twitter', [
                'wrapper'   =>  ['width' => '50%']
            ])
            ->addUrl('Instagram', [
                'wrapper'   =>  ['width' => '50%']
            ])
            ->addUrl('LinkedIn', [
                'wrapper'   =>  ['width' => '50%']
            ])
            ->addUrl('YouTube', [
                'wrapper'   =>  ['width' => '50%']
            ]);

        return $fields->build();
    }
}
