<?php

namespace SmaatCoda\PokerRankr\Interfaces;

/**
 * Interface EntityInterface
 * @package SmaatCoda\PokerRankr\Contracts
 */
interface EntityInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param array $data
     * @return EntityInterface
     */
    public static function fromArray(array $data);
}
