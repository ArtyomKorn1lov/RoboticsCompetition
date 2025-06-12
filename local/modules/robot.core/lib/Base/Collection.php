<?php

namespace Robot\Core\Base;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use RuntimeException;
use InvalidArgumentException;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Коллекция объектов определённого класса
 * @template T
 * @template-implements IteratorAggregate<T>
 */
abstract class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    /** @var array<T> Элементы коллекции */
    private array $items;

    /**
     * @param array $items
     * @throws RuntimeException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->instanceOf($this->type(), $item);
        }
        $this->items = $items;
    }

    /**
     * @return array<T>
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items());
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items());
    }

    /**
     * @return T
     */
    public function first()
    {
        $iterator = $this->getIterator();

        return $iterator->valid() ? $iterator->current() : null;
    }

    /**
     * @param callable $callback
     * @return Collection
     * @throws RuntimeException
     */
    public function filter(callable $callback): static
    {
        return new static(array_filter($this->items(), $callback));
    }

    /**
     * @param callable $callback
     * @return T
     * @throws RuntimeException
     */
    public function find(callable $callback)
    {
        return $this->filter($callback)->first();
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return null
     * @throws RuntimeException
     */
    public function findBy(string $key, mixed $value)
    {
        return $this->find(fn($item) => $item->$key === $value);
    }

    /**
     * @param callable $callback
     * @return array<T>
     */
    public function mapToArray(callable $callback): array
    {
        return array_map($callback, $this->items());
    }

    /**
     * @param callable $callback
     * @return Collection
     * @throws RuntimeException
     */
    public function map(callable $callback): static
    {
        return new static($this->mapToArray($callback));
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     * @return T
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param T $value
     * @return void
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$this->offsetExists($offset)) {
            throw new InvalidArgumentException(Loc::getMessage("ROBOT_CORE_COLLECTION_INVALID_OFFSET"));
        }
        $this->instanceOf($this->type(), $value);
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset)) {
            throw new InvalidArgumentException(Loc::getMessage("ROBOT_CORE_COLLECTION_INVALID_OFFSET"));
        }
        unset($this->items[$offset]);
    }

    /**
     * @param T $value
     * @return void
     */
    public function add(mixed $value): void
    {
        $this->instanceOf($this->type(), $value);
        $this->items[] = $value;
    }

    /**
     * @param mixed $collection
     * @return void
     */
    public function merge(mixed $collection): void
    {
        if (!($collection instanceof static)) {
            throw new InvalidArgumentException(Loc::getMessage("ROBOT_CORE_COLLECTION_INVALID_COLLECTION_INSTANCE", ["#CLASS#" => static::class]));
        }
        $this->items = array_merge($this->items(), $collection->items());
    }

    /**
     * @param mixed $collection
     * @return void
     */
    public function replace(mixed $collection): void
    {
        if (!($collection instanceof static)) {
            throw new InvalidArgumentException(Loc::getMessage("ROBOT_CORE_COLLECTION_INVALID_COLLECTION_INSTANCE", ["#CLASS#" => static::class]));
        }
        $this->items = $collection->items();
    }

    /**
     * @param string $class
     * @param mixed $element
     * @return void
     * @throws RuntimeException
     */
    protected function instanceOf(string $class, mixed $element): void
    {
        if (!($element instanceof $class)) {
            throw new InvalidArgumentException(Loc::getMessage('ROBOT_CORE_COLLECTION_INVALID_ITEM', ['#ITEM#' => is_object($element) ? get_class($element) : var_export($element, true), '#CLASS#' => $class]));
        }
    }

    /**
     * @return class-string<T>
     */
    abstract protected function type(): string;
}