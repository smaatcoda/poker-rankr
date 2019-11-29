<?php

namespace SmaatCoda\PokerRankr\Interfaces;

/**
 * Interface CollectionInterface
 * @package SmaatCoda\PokerRankr\Interfaces
 */
interface CollectionInterface
{
    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return mixed
     */
    public function filter();

    /**
     * @return mixed
     */
    public function sort();

    /**
     * @return mixed
     */
    public function first();

    /**
     * @param array $data
     * @return mixed
     */
    public static function fromArray(array $data);

    /**
     * @return array
     */
    public function toArray(): array;
}