<?php

namespace INY\Core\Service;

use Bitrix\Main\SystemException;
use INY\Core\Domain\Exception\ModuleValidationException;
use INY\Core\UseCase\CreateModule\CreateModuleCommand;
use INY\Core\UseCase\CreateModule\CreateModuleHandler;

/**
 * class ModuleService
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Service
 */
class ModuleService
{
    public function __construct(
        private readonly CreateModuleHandler $createModuleHandler,
    ) {
    }

    /**
     * @param array{
     *      id:string,
     *      name:string,
     *      description:string,
     *      phpVersion:float,
     *      partnerName:string,
     *      partnerUri:string,
     *  } $moduleParam
     *
     * @return void
     * @throws SystemException
     * @throws ModuleValidationException
     */
    public function create(array $moduleParam): void
    {
        $this->createModuleHandler->handle(
            new CreateModuleCommand(
                $moduleParam['id'],
                $moduleParam['name'],
                $moduleParam['description'],
                $moduleParam['phpVersion'],
                $moduleParam['partnerName'],
                $moduleParam['partnerUri'],
            )
        );
    }
}
