<?php

namespace INY\Core\Trait\DI;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\ObjectNotFoundException;
use Psr\Container\NotFoundExceptionInterface;

/**
 * trait ContainerTrait
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Trait
 */
trait ContainerTrait
{
    /**
     * @return static
     * @throws NotFoundExceptionInterface
     * @throws ObjectNotFoundException
     */
    public static function getInstance(): static
    {
        $serviceLocator = ServiceLocator::getInstance();
        if ($serviceLocator->has(static::class) === false) {
            $serviceLocator->addInstance(static::class, new static());
        }

        return $serviceLocator->get(static::class);
    }
}
