<?php

namespace PHPSTORM_META {

    registerArgumentsSet(
        'iny_core_serviceLocator_codes',
        'iny.service.module.create',
    );

    expectedArguments(\Bitrix\Main\DI\ServiceLocator::get(), 0, argumentsSet('iny_core_serviceLocator_codes'));

    override(\Bitrix\Main\DI\ServiceLocator::get(0), map([
        'iny.service.module.create' => \INY\Core\Service\ModuleService::class,
    ]));
}
