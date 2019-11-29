<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use Ds\Set;
use SmaatCoda\PokerRankr\Interfaces\CollectionInterface;
use SmaatCoda\PokerRankr\PokerRanking;

/**
 * Class PokerHand
 * @method  \ArrayIterator|PokerCard[] getIterator()
 * @package SmaatCoda\PokerRankr\Entities
 */
class PokerHand implements CollectionInterface, \IteratorAggregate
{
    use CollectionTrait;

    /**
     * @var null|PokerRanking
     */
    protected $ranking;

    /**
     * PokerHand constructor.
     * @param PokerCard ...$cards
     */
    public function __construct(PokerCard ...$cards)
    {
        $this->values = new Set(...[$cards]);
    }

    /**
     * @param array $values
     * @return  PokerHand
     */
    public static function fromArray(array $cards)
    {
        return new self(...array_map(function ($card) {
            return PokerCard::fromArray($card);
        }, $cards));
    }

    /**
     * @return PokerRanking|null
     */
    public function getRanking(): ?PokerRanking
    {
        return $this->ranking;
    }

    /**
     * @param PokerRanking|null $ranking
     */
    public function setRanking(?PokerRanking $ranking): void
    {
        $this->ranking = $ranking;
    }
}
