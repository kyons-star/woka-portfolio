<?php

namespace App\Support;

class SamplePortfolio
{
    /** Placeholder content used for the template previews. */
    public static function data(): array
    {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit sed diam nonummy.';

        return [
            'name'    => 'Your Name',
            'email'   => 'youremail@example.com',
            'phone'   => '+00 000 000 0000',
            'address' => 'Your Address',
            'pic'     => asset('images/sample-avatar.jpg'),
            'soc'     => [['label' => 'yourlink.com', 'url' => 'yourlink.com']],
            'about'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
            'skills'  => 'Skill One, Skill Two, Skill Three',
            'proj'    => [
                ['title' => 'Project Title', 'desc' => $lorem],
                ['title' => 'Project Title', 'desc' => $lorem],
            ],
            'work'    => [[
                'role'    => 'Job Title',
                'company' => 'Company Name',
                'years'   => 'Year – Year',
                'desc'    => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            ]],
            'edu'     => [[
                'degree' => 'Degree Name',
                'school' => 'School Name',
                'years'  => 'Year – Year',
            ]],
        ];
    }
}