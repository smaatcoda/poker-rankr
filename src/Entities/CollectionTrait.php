<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use SmaatCoda\PokerRankr\Interfaces\EntityInterface;

/**
 * Trait CollectionTrait.
 *
 * @package SmaatCoda\PokerRankr\Entities
 */
trait CollectionTrait
{
    /**
     * @var \Ds\Set
     */
    protected $values;

    /**
     * Recursively transforms collection and its contents into array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (EntityInterface $entity) {
            return $entity->toArray();
        }, $this->values->toArray());
    }

    /**
     * Returns iterator.
     *
     * @return \Generator|\Traversable
     */
    public function getIterator()
    {
        return $this->values->getIterator();
    }

    /**
     * Adds zero or more values to the collection.
     *
     * @param EntityInterface ...$values
     */
    public function add(EntityInterface ...$values)
    {
        return $this->values->add(...$values);
    }

    /**
     * Returns the number of elements in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->values->count();
    }

    /**
     * Returns the first value in the collection.
     *
     * @return mixed|null
     */
    public function first()
    {
        return $this->count() ? $this->values->first() : null;
    }

    /**
     * Returns a new collection containing only the values for which a callback
     * returns true. A boolean test will be used if a callback is not provided.
     *
     * @param callable|null $callback
     * @return $this
     */
    public function filter(callable $callback = null)
    {
        return new static(...$this->values->filter($callback)->toArray());
    }

    /**
     * Iteratively reduces the collection to a single value using a callback.
     *
     * @param callable $callback
     * @param null $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return $this->values->reduce($callback, $initial);
    }

    /**
     * Sorts the set in-place, based on an optional callable comparator.
     *
     * @param callable|null $callback
     * @return $this
     */
    public function sort(callable $callback = null)
    {
        $this->values->sort($callback);

        return $this;
    }
}