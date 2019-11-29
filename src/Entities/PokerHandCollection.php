<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use Ds\Set;
use SmaatCoda\PokerRankr\Interfaces\CollectionInterface;
use SmaatCoda\PokerRankr\Interfaces\EntityInterface;

/**
 * Class PokerHandCollection
 * @method  \ArrayIterator|PokerHand[] getIterator()
 * @package SmaatCoda\PokerRankr\Entities
 */
class PokerHandCollection implements CollectionInterface, \IteratorAggregate
{
    use CollectionTrait;

    /**
     * AbstractCollection constructor.
     * @param EntityInterface|null ...$hands
     */
    public function __construct(?PokerHand ...$hands)
    {
        $this->values = new Set(...[$hands]);
    }
    /**
     * @param array $values
     * @return mixed|PokerHandCollection
     */
    public static function fromArray(array $hands)
    {
        return new self(...array_map(function ($hand) {
            return PokerHand::fromArray($hand);
        }, $hands));
    }
}