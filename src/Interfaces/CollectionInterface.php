<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Interfaces;

/**
 * Interface CollectionInterface
 *
 * @package SmaatCoda\PokerRankr\Interfaces
 */
interface CollectionInterface
{
    /**
     * Returns the number of elements in the collection.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Returns a new collection containing only the values for which a callback
     * returns true. A boolean test will be used if a callback is not provided.
     *
     * @return mixed
     */
    public function filter();

    /**
     * Sorts the set in-place, based on an optional callable comparator.
     *
     * @return mixed
     */
    public function sort();

    /**
     * Returns the first value in the collection.
     *
     * @return mixed
     */
    public function first();

    /**
     * Iteratively reduces the collection to a single value using a callback.
     *
     * @param callable $callback
     * @param null $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null);

    /**
     * @param array $data
     * @return mixed
     */
    public static function fromArray(array $data);

    /**
     * Recursively converts collection and its contents into array.
     *
     * @return array
     */
    public function toArray(): array;
}