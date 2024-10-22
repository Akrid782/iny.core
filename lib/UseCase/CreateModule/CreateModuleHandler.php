<?php

namespace INY\Core\UseCase\CreateModule;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use INY\Core\Domain\Factory\ModuleFactory;
use INY\Core\Domain\Repository\ModuleRepositoryInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * class CreateModuleHandler
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\UseCase\CreateModule
 */
class CreateModuleHandler
{
    public function __construct(private readonly ModuleRepositoryInterface $moduleRepository)
    {
    }

    /**
     * @throws ArgumentException
     * @throws ObjectNotFoundException
     * @throws NotFoundExceptionInterface
     * @throws SystemException
     */
    public function handle(CreateModuleCommand $createModuleCommand): void
    {
        $module = ModuleFactory::getInstance()->create(
            $createModuleCommand->getId(),
            $createModuleCommand->getName(),
            $createModuleCommand->getDescription(),
            $createModuleCommand->getPartnerName(),
            $createModuleCommand->getPartnerUri(),
            $createModuleCommand->getPhpVersion(),
            $createModuleCommand->getDir(),
        );
        if ($this->moduleRepository->isExists($module->getId())) {
            throw new SystemException(
                (string) Loc::getMessage('INY_CORE_USE_CASE_CREATE_MODULE_EXISTS_ERROR', [
                    '#MODULE_ID#' => $module->getId()->value,
                ])
            );
        }

        $this->moduleRepository->create($module);
    }
}
