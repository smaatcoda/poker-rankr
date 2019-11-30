<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use Ds\Set;
use SmaatCoda\PokerRankr\Interfaces\CollectionInterface;

/**
 * Class PokerHandCollection
 *
 * @method  \ArrayIterator|PokerHand[] getIterator()
 * @package SmaatCoda\PokerRankr\Entities
 */
class PokerHandCollection implements CollectionInterface, \IteratorAggregate
{
    use CollectionTrait;

    /**
     * AbstractCollection constructor.
     *
     * @param PokerHand|null ...$hands
     */
    public function __construct(?PokerHand ...$hands)
    {
        $this->values = new Set(...[$hands]);
    }

    /**
     * Instantiates a new poker hand collection from an array
     *
     * @param array $hands
     *
     * @return mixed|PokerHandCollection
     */
    public static function fromArray(array $hands)
    {
        return new self(...array_map(function ($hand) {
            return PokerHand::fromArray($hand);
        }, $hands));
    }
}