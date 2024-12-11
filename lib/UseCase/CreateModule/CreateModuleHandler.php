<?php

namespace INY\Core\UseCase\CreateModule;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\SystemException;
use INY\Core\Domain\Exception\ModuleValidationException;
use INY\Core\Domain\Factory\ModuleFactory;
use INY\Core\Domain\Repository\ModuleRepositoryInterface;

/**
 * class CreateModuleHandler
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\UseCase\CreateModule
 */
class CreateModuleHandler
{
    public function __construct(private readonly ModuleRepositoryInterface $moduleRepository)
    {
    }

    /**
     * @throws SystemException
     * @throws ModuleValidationException
     */
    public function handle(CreateModuleCommand $createModuleCommand): void
    {
        $module = ModuleFactory::create(
            $createModuleCommand->getId(),
            $createModuleCommand->getName(),
            $createModuleCommand->getDescription(),
            $createModuleCommand->getPartnerName(),
            $createModuleCommand->getPartnerUri(),
            $createModuleCommand->getPhpVersion(),
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
