<?php

use INY\Core\Cli\Command\Make\ModuleCommand;

return [
    'console' => [
        'value' => [
            'commands' => [
                ModuleCommand::class,
            ],
        ],
        'readonly' => true,
    ],
];
