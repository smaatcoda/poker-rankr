<?php

namespace SmaatCoda\PokerRankr\Entities;

use SmaatCoda\PokerRankr\Interfaces\EntityInterface;

/**
 * Trait CollectionTrait
 * @package SmaatCoda\PokerRankr\Entities
 */
trait CollectionTrait
{
    /**
     * @var \Ds\Set
     */
    protected $values;

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (EntityInterface $entity) {
            return $entity->toArray();
        }, $this->values->toArray());
    }

    /**
     * @return \Generator|\Traversable
     */
    public function getIterator()
    {
        return $this->values->getIterator();
    }

    /**
     * @param EntityInterface ...$values
     */
    public function add(EntityInterface ...$values)
    {
        return $this->values->add(...$values);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->values->count();
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        return $this->count() ? $this->values->first() : null;
    }

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function filter(callable $callback = null)
    {
        return new static($this->values->filter($callback)->toArray());
    }

    /**
     * @param callable $callback
     * @param null $initial
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return $this->values->reduce($callback, $initial);
    }

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function sort(callable $callback = null)
    {
        $this->values->sort($callback);

        return $this;
    }
}