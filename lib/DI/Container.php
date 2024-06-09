<?php

namespace INY\Core\DI;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ObjectNotFoundException;

/**
 * Контейнер
 * ---
 * Контейнер DI для централизованного определения и управления зависимостями. Это помогает переиспользовать существующий
 * код и экземпляры объектов, что в свою очередь позволяет сделать кодовую базу более удобной в обслуживании
 * и тестируемой.
 *
 * Пример:
 * ```
 * use INY\Core\DI\Container;
 *
 * class UserRepository
 * {
 *      public static function get(): self
 *      {
 *          return Container::get(self::class);
 *      }
 *
 *
 *      public function getByID(int $ID): array
 *      {
 *          // db request
 *      }
 *
 *      ...
 * }
 * ```
 *
 * @package DI
 * @phpstan-template T of object
 */
class Container
{
    /**
     * @var array<class-string<T>, T>
     */
    private static array $instances = [];

    /**
     * @param string                  $className
     *
     * @phpstan-param class-string<T> $className
     * @phpstan-return T
     *
     * @return object
     * @throws ObjectNotFoundException
     */
    public static function get(string $className): object
    {
        if (self::has($className)) {
            return self::$instances[$className];
        }

        self::verifyExistsClass($className);

        return self::makeInstance($className);
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public static function has(string $className): bool
    {
        return array_key_exists($className, self::$instances);
    }

    /**
     * @param string $className
     *
     * @return void
     * @throws ObjectNotFoundException
     */
    private static function verifyExistsClass(string $className): void
    {
        if (!class_exists($className)) {
            throw new ObjectNotFoundException(
                (string) Loc::getMessage('INY_CORE_DI_CONTAINER_CLASS_NOT_FOUND', [
                    '#CLASS_NAME#' => $className,
                ])
            );
        }
    }

    /**
     * @param string                  $className
     *
     * @phpstan-param class-string<T> $className
     * @phpstan-return T
     *
     * @return object
     */
    protected static function makeInstance(string $className): object
    {
        return self::$instances[$className] = new $className();
    }
}
