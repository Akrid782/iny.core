<?php

namespace INY\Core\Collect;

use Countable;
use Stringable;
use ArrayAccess;
use Traversable;
use ArrayIterator;
use IteratorAggregate;
use ReturnTypeWillChange;
use INY\Core\Collect\Trait\Proxyable;

/**
 * class AArray
 *
 * @package INY\Core\Collect
 */
abstract class AArray implements ArrayAccess, Stringable, Countable, IteratorAggregate
{
    use Proxyable;

    /**
     * @param array $items
     */
    public function __construct(protected array $items = [])
    {
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    protected function createInstance(array $items): static
    {
        return new static($items);
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    #[ReturnTypeWillChange]
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]) || array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    #[ReturnTypeWillChange]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    #[ReturnTypeWillChange]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($offset === null) {
            $this->items[] = $value;

            return;
        }

        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     *
     * @return void
     */
    #[ReturnTypeWillChange]
    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * <p>Получить количество элементов в коллекции.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];;
     * $collection = new Collection($array);
     * $collection->count(); // 2
     * </code>
     *
     * @return int
     */
    #[ReturnTypeWillChange]
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * <p>Получить hash коллекции.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];;
     * $collection = new Collection($array);
     * echo $collection; // 00000000000000d90000000000000000
     * </code>
     *
     * @return string
     */
    #[ReturnTypeWillChange]
    public function __toString(): string
    {
        return spl_object_hash($this);
    }

    /**
     * <p>Получить итератор для элементов коллекции.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     * foreach ($collection as $key => $value) {
     *      // $key = 'param1'
     *      // $value = 'value'
     * }
     * </code>
     *
     * @return Traversable
     */
    #[ReturnTypeWillChange]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * <p>Проверка пустая коллекция или нет.</p>
     * <p>Пример:</p>
     * <code>
     * $array = [];
     * $collection = new Collection($array);
     *
     * // Результат true
     * $collection->isEmpty();
     * </code>
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}
