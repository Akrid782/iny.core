<?php

namespace INY\Core\Domain\Repository;

use INY\Core\Domain\Entity\Module;
use INY\Core\Domain\ValueObject\Module\Id;

/**
 * interface ModuleRepositoryInterface
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Domain\Repository
 */
interface ModuleRepositoryInterface
{
    public function isExists(Id $id): bool;

    public function create(Module $module): bool;
}
