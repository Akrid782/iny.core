<?php

namespace INY\Core\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Bitrix\Main\Request;
use INY\Core\Infrastructure\Repository\ModuleRepository;
use INY\Core\Service\ModuleService;
use INY\Core\UseCase\CreateModule\CreateModuleHandler;
use Throwable;

/**
 * class ModuleCreatorController
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Controller
 */
class ModuleCreatorController extends Controller
{
    private ModuleRepository $repository;

    public function __construct(?Request $request = null)
    {
        parent::__construct($request);

        $this->repository = new ModuleRepository();
    }

    /**
     * @param array<string, string|float> $moduleParam
     *
     * @return bool
     */
    public function createAction(array $moduleParam): bool
    {
        try {
            $moduleService = new ModuleService(new CreateModuleHandler($this->repository));
            $moduleService->create($moduleParam);
        } catch (Throwable $exception) {
            $this->addError(
                new Error(
                    $exception->getMessage(),
                    $exception->getCode(),
                )
            );
        }

        return empty($this->getErrors());
    }
}
