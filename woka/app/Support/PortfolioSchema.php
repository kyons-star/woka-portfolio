<?php

namespace App\Support;

class PortfolioSchema
{
    public const STYLES = [
        'Simple'   => 'Clean and minimal',
        'Modern'   => 'Bold header, structured cards',
        'Creative' => 'Warm, expressive layout',
    ];

    /** Short descriptions used on the dashboard "Choose a template" cards. */
    public const PICK_TEXT = [
        'Simple'   => 'Plain and readable',
        'Modern'   => 'Bold header, project grid',
        'Creative' => 'Warm, loose layout',
    ];

    /**
     * Repeating sections of the editor form.
     * Each field: [name, label, type] where type "ta" = textarea.
     */
    public const LISTS = [
        'edu' => [
            'title'  => 'Educational background',
            'add'    => 'Add education',
            'fields' => [
                ['school', 'School / University', 'text'],
                ['degree', 'Degree / Course', 'text'],
                ['years', 'Years (e.g. 2019 to 2023)', 'text'],
            ],
        ],
        'proj' => [
            'title'  => 'Projects',
            'add'    => 'Add project',
            'fields' => [
                ['title', 'Project title', 'text'],
                ['desc', 'Description', 'ta'],
                ['link', 'Project link (optional)', 'text'],
            ],
        ],
        'work' => [
            'title'  => 'Work experience',
            'add'    => 'Add experience',
            'fields' => [
                ['company', 'Company', 'text'],
                ['role', 'Role', 'text'],
                ['years', 'Years', 'text'],
                ['desc', 'What you did', 'ta'],
            ],
        ],
        'soc' => [
            'title'  => 'Social media / website links',
            'add'    => 'Add link',
            'fields' => [
                ['label', 'Platform (e.g. LinkedIn)', 'text'],
                ['url', 'URL', 'text'],
            ],
        ],
    ];

    public static function styleNames(): array
    {
        return array_keys(self::STYLES);
    }
}