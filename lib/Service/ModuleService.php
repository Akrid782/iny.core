<?php

namespace INY\Core\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use INY\Core\UseCase\CreateModule\CreateModuleCommand;
use INY\Core\UseCase\CreateModule\CreateModuleHandler;
use Psr\Container\NotFoundExceptionInterface;

/**
 * class ModuleService
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
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
     *      dir:string
     *  } $moduleParam
     *
     * @return void
     * @throws ArgumentException
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     * @throws SystemException
     */
    public function create(array $moduleParam): void
    {
        $command = new CreateModuleCommand(
            $moduleParam['id'],
            $moduleParam['name'],
            $moduleParam['description'],
            $moduleParam['phpVersion'],
            $moduleParam['partnerName'],
            $moduleParam['partnerUri'],
            $moduleParam['dir'],
        );
        $this->createModuleHandler->handle($command);
    }
}
