<?php

namespace INY\Core\Collect;

use Closure;
use Bitrix\Main\ArgumentOutOfRangeException;

/**
 * class Collection
 *
 * @package INY\Core\Collection
 */
class Collection extends AArray implements IReadable, IModifierable, IInspectorable
{
    /**
     * <p>Проверяет наличие элемента в коллекции по ключу.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат true
     * $collection->isExistsByKey('param2');
     * </code>
     *
     * @param string|int $key
     *
     * @return bool
     */
    public function isExistsByKey(string|int $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * <p>Проверяет наличие элемента в коллекции по его значению.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат true
     * $collection->isExistsByValue('value2');
     * </code>
     *
     * @param mixed $value
     * @param bool $strict
     *
     * @return bool
     */
    public function isExistsByValue(mixed $value, bool $strict = true): bool
    {
        return in_array($value, $this->items, $strict);
    }

    /**
     * <p>Проверяет наличие элемента в коллекции через callback.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат true
     * $collection->isExists(fn($key, $item) => $key === 'param1');
     *
     * // Результат true
     * $collection->isExists(static fn($key, $item) => $item === 'value2');
     *
     * // Результат true
     * $collection->isExists(function($key, $item) {
     *      return $key === 'param2' && $item === 'value2';
     * });
     *
     * // Результат false
     * $collection->isExists(static function($key, $item) {
     *      return $item === 'value3';
     * });
     * </code>
     *
     * @param Closure $closure
     *
     * @return bool
     */
    public function isExists(Closure $closure): bool
    {
        foreach ($this->items as $key => $item) {
            if ($closure($key, $item)) {
                return true;
            }
        }

        return false;
    }

    /**
     * <p>Получить значение из коллекции.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат value2
     * $collection->getItem('param2');
     *
     * // Результат null
     * $collection->getItem('param3');
     *
     * // Результат ['default' => 'value']
     *  $collection->getItem('param3', ['default' => 'value']);
     * </code>
     *
     * @param string|int $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function getItem(string|int $key, mixed $default = null): mixed
    {
        if ($this->isExistsByKey($key)) {
            return $this->offsetGet($key);
        }

        return $default;
    }

    /**
     * <p>Получить коллекцию ключей.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат ['param1', 'param2']
     * $collectKeys = $collection->getKeys()->toArray();
     * </code>
     *
     * @return Collection
     */
    public function getKeys(): Collection
    {
        return $this->createInstance(array_keys($this->items));
    }

    /**
     * <p>Получить коллекцию значений.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат ['value', 'value2']
     * $collectValues = $collection->getValues()->toArray();
     * </code>
     *
     * @return Collection
     */
    public function getValues(): Collection
    {
        return $this->createInstance(array_values($this->items));
    }

    /**
     * <p>Поиск значения в коллекции.</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат 'param1'
     * $collection = $collection->search('value');
     *
     * // Результат false
     * $collection = $collection->search('value3');
     * </code>
     *
     * @param mixed $value
     * @param bool $strict
     *
     * @return int|string|bool
     */
    public function search(mixed $value, bool $strict = true): int|string|bool
    {
        return array_search($value, $this->items, $strict);
    }

    /**
     * <p>Добавить новое значение в коллекцию</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат ['param1' => 'value', 'param2' => 'value2', 0 => 'value3']
     * $collection->add('value3')->toArray();
     * </code>
     *
     * @param mixed $item
     *
     * @return Collection
     */
    public function add(mixed $item): Collection
    {
        $this->offsetSet(null, $item);

        return $this;
    }

    /**
     * <p>Добавить новое элемент в коллекцию</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2'];
     * $collection = new Collection($array);
     *
     * // Результат ['param1' => 'value', 'param2' => 'value2', 'param3' => 'value3']
     * $collection->put('param3', 'value3')->toArray();
     * </code>
     *
     * @param string|int $key
     * @param mixed $item
     *
     * @return Collection
     */
    public function put(string|int $key, mixed $item): Collection
    {
        $this->offsetSet($key, $item);

        return $this;
    }

    /**
     * <p>Удаление значения из коллекции</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2', 0 => 'value3'];
     * $collection = new Collection($array);
     *
     * // Результат ['param1' => 'value', 0 => 'value3']
     * $collection->forget('param2')->toArray();
     *
     * // Результат ['param2' => 'value2']
     * $collection->forget([0, 'param1'])->toArray();
     * </code>
     *
     * @param string|int|array $keys
     *
     * @return Collection
     */
    public function forget(string|int|array $keys): Collection
    {
        foreach ((array) $keys as $key) {
            $this->offsetUnset($key);
        }

        return $this;
    }

    /**
     * <p>Удалить последний элемент коллекции</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2', 0 => 'value3'];
     * $collection = new Collection($array);
     *
     * // Результат ['param1' => 'value', 'param2' => 'value2]
     * $collection->pop()->toArray();
     *
     * // Результат ['param1' => 'value']
     * $collection->pop(2)->toArray();
     * </code>
     *
     * @param int $count
     *
     * @return Collection
     */
    public function pop(int $count = 1): Collection
    {
        if ($count === 1) {
            array_pop($this->items);

            return $this;
        }

        if ($this->isEmpty()) {
            return $this;
        }

        $results = [];
        for ($i = 1; $i <= min($count, $this->count()); $i++) {
            $results[] = array_pop($this->items);
        }

        return $this->createInstance($results);
    }

    /**
     * <p>Удалить первый элемент коллекции</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2', 0 => 'value3'];
     * $collection = new Collection($array);
     *
     * // Результат ['param2' => 'value2, 0 => 'value3']
     * $collection->shift()->toArray();
     *
     * // Результат [0 => 'value3']
     * $collection->shift(2)->toArray();
     * </code>
     *
     * @param int $count
     *
     * @return Collection
     */
    public function shift(int $count = 1): Collection
    {
        if ($count === 1) {
            array_shift($this->items);

            return $this;
        }

        if ($this->isEmpty()) {
            return $this;
        }

        $result = [];
        for ($i = 1; $i <= min($count, $this->count()); $i++) {
            $result[] = array_shift($this->items);
        }

        return $this->createInstance($result);
    }

    /**
     * <p>Разрезать коллекцию</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2', 0 => 'value3'];
     * $collection = new Collection($array);
     *
     * // Результат ['param2' => 'value2, 0 => 'value3']
     * $collection->slice(1, 2)->toArray();
     * </code>
     *
     * @param int $offset
     * @param int|null $length
     * @param bool $preserveKeys
     *
     * @return Collection
     */
    public function slice(int $offset, int|null $length = null, bool $preserveKeys = true): Collection
    {
        return $this->createInstance(array_slice($this->items, $offset, $length, $preserveKeys));
    }

    /**
     * <p>Разделить коллекцию на фрагменты заданного размера</p>
     * <p>Пример:</p>
     * <code>
     * $array = ['param1' => 'value', 'param2' => 'value2', 0 => 'value3', 1 => 'value4'];
     * $collection = new Collection($array);
     *
     * Результат [
     *      INY\Core\Collect\Collection Object(
     *          [items:protected] => ['param1' => 'value', 'param2' => 'value2']
     *      ),
     *      INY\Core\Collect\Collection Object(
     *          [items:protected] => [0 => 'value3', 1 => value4]
     *      )
     * ]
     * $collection->chunk(2);
     * </code>
     *
     * @param int $size
     * @param bool $preserveKeys
     *
     * @return array<int, Collection>
     * @throws ArgumentOutOfRangeException
     */
    public function chunk(int $size, bool $preserveKeys = true): array
    {
        if ($size <= 0) {
            throw new ArgumentOutOfRangeException('size', 1);
        }

        $chunkItems = [];
        foreach (array_chunk($this->items, $size, $preserveKeys) as $chunk) {
            $chunkItems[] = $this->createInstance($chunk);
        }

        return $chunkItems;
    }
}
