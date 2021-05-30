<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr;

/**
 * Class PokerRanking
 *
 * The result of an evaluation of a hand performed by PokerRankr.
 *
 * @package SmaatCoda\PokerRankr
 */
class PokerRanking
{
    /**
     * @var int Numeric value of a hand ranking.
     */
    public const ROYAL_FLUSH = 10;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const STRAIGHT_FLUSH = 9;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const FOUR_OF_KIND = 8;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const FULL_HOUSE = 7;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const FLUSH = 6;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const STRAIGHT = 5;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const THREE_OF_KIND = 4;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const TWO_PAIRS = 3;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const PAIR = 2;

    /**
     * @var int Numeric value of a hand ranking.
     */
    public const HIGH_CARD = 1;

    /**
     * @var integer Numeric value of the ranking.
     */
    protected $rankingValue;

    /**
     * @var integer Numeric value of playing cards.
     */
    protected $mainCardsValue;

    /**
     * @var integer Numeric value of the first kicker.
     */
    protected $kickerOneValue;

    /**
     * @var integer Numeric value of the second kicker.
     */
    protected $kickerTwoValue;

    /**
     * @var integer Numeric value of the third kicker.
     */
    protected $kickerThreeValue;

    /**
     * @var integer Numeric value of the fourth kicker.
     */
    protected $kickerFourValue;

    /**
     * PokerRanking constructor.
     *
     * @param int $rankingValue Numeric value of the ranking.
     * @param int $mainCardsValue Numeric value of playing cards.
     * @param int $kickerOneValue Numeric value of the first kicker.
     * @param int $kickerTwoValue Numeric value of the second kicker.
     * @param int $kickerThreeValue Numeric value of the third kicker.
     * @param int $kickerFourValue Numeric value of the fourth kicker.
     */
    public function __construct(
        int $rankingValue,
        int $mainCardsValue,
        int $kickerOneValue = 0,
        int $kickerTwoValue = 0,
        int $kickerThreeValue = 0,
        int $kickerFourValue = 0
    ) {
        $this->rankingValue     = $rankingValue;
        $this->mainCardsValue   = $mainCardsValue;
        $this->kickerOneValue   = $kickerOneValue;
        $this->kickerTwoValue   = $kickerTwoValue;
        $this->kickerThreeValue = $kickerThreeValue;
        $this->kickerFourValue  = $kickerFourValue;
    }

    /**
     * Returns the n  *  Numeric value of the ranking.
     * @return int
     */
    public function getValue(): int
    {
        return $this->rankingValue;
    }

    /**
     * Returns the n  *  Numeric value of playing cards.
     * @return int
     */
    public function getMainCardsValue(): int
    {
        return $this->mainCardsValue;
    }

    /**
     * Returns the numeric value of the first kicker.
     * @return int
     */
    public function getKickerOneValue(): int
    {
        return $this->kickerOneValue;
    }

    /**
     * Returns the numeric value of the second kicker.
     * @return int
     */
    public function getKickerTwoValue(): int
    {
        return $this->kickerTwoValue;
    }

    /**
     * Returns the numeric value of the third kicker.
     * @return int
     */
    public function getKickerThreeValue(): int
    {
        return $this->kickerThreeValue;
    }

    /**
     * Returns the numeric value of the fourth kicker.
     * @return int
     */
    public function getKickerFourValue(): int
    {
        return $this->kickerFourValue;
    }

    /**
     * Verifies if the ranking beats another ranking.
     *
     * @param PokerRanking $pokerRank
     * @return bool
     */
    public function beats(PokerRanking $pokerRank): bool
    {
        if ($this->getValue() !== $pokerRank->getValue()) {
            return $this->getValue() > $pokerRank->getValue();
        }

        if ($this->getMainCardsValue() !== $pokerRank->getMainCardsValue()) {
            return $this->getMainCardsValue() > $pokerRank->getMainCardsValue();
        }

        if ($this->getKickerOneValue() !== $pokerRank->getKickerOneValue()) {
            return $this->getKickerOneValue() > $pokerRank->getKickerOneValue();
        }

        if ($this->getKickerTwoValue() !== $pokerRank->getKickerTwoValue()) {
            return $this->getKickerTwoValue() > $pokerRank->getKickerTwoValue();
        }

        if ($this->getKickerThreeValue() !== $pokerRank->getKickerThreeValue()) {
            return $this->getKickerThreeValue() > $pokerRank->getKickerThreeValue();
        }

        if ($this->getKickerFourValue() !== $pokerRank->getKickerFourValue()) {
            return $this->getKickerFourValue() > $pokerRank->getKickerFourValue();
        }

        return false;
    }
}
