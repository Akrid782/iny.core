<?php

use INY\Core\Cli\Command\Make\ModuleCommand;
use INY\Core\Infrastructure\Repository\ModuleRepository;
use INY\Core\Service\ModuleService;
use INY\Core\UseCase\CreateModule\CreateModuleHandler;

return [
    'console' => [
        'value' => [
            'commands' => [
                ModuleCommand::class,
            ],
        ],
        'readonly' => true,
    ],
    'services' => [
        'value' => [
            'iny.service.module.create' => [
                'constructor' => static function () {
                    $repository = new ModuleRepository();
                    $createModuleHandler = new CreateModuleHandler($repository);

                    return new ModuleService($createModuleHandler);
                },
            ],
        ],
    ],
];
