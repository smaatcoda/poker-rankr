<?php


namespace SmaatCoda\PokerRankr;


class PokerRanking
{
    public const ROYAL_FLUSH = 1000;
    public const STRAIGHT_FLUSH = 900;
    public const FOUR_OF_KIND = 800;
    public const FULL_HOUSE = 700;
    public const FLUSH = 600;
    public const STRAIGHT = 500;
    public const THREE_OF_KIND = 400;
    public const TWO_PAIRS = 300;
    public const PAIR = 200;
    public const HIGH_CARD = 100;

    /**
     * @var integer
     */
    protected $rankingValue;

    /**
     * @var integer
     */
    protected $mainCardsValue;

    /**
     * @var integer
     */
    protected $kickerOneValue;

    /**
     * @var integer
     */
    protected $kickerTwoValue;

    /**
     * @var integer
     */
    protected $kickerThreeValue;

    /**
     * @var integer
     */
    protected $kickerFourValue;

    /**
     * TexasHoldemRank constructor.
     * @param int $rankingValue The value of the rank
     * @param int $mainCardsValue The collective value of played card ranks
     * @param int $kickerOneValue The rank value of the first kicker
     * @param int $kickerTwoValue The rank value of the second kicker
     * @param int $kickerThreeValue The rank value of the third kicker
     * @param int $kickerFourValue The rank value of the fourth kicker
     */
    public function __construct(
        int $rankingValue,
        int $mainCardsValue,
        int $kickerOneValue = 0,
        int $kickerTwoValue = 0,
        int $kickerThreeValue = 0,
        int $kickerFourValue = 0
    ) {
        $this->rankingValue = $rankingValue;
        $this->mainCardsValue = $mainCardsValue;
        $this->kickerOneValue = $kickerOneValue;
        $this->kickerTwoValue = $kickerTwoValue;
        $this->kickerThreeValue = $kickerThreeValue;
        $this->kickerFourValue = $kickerFourValue;
    }

    /**
     * @return int
     */
    public function getRankingValue(): int
    {
        return $this->rankingValue;
    }

    /**
     * @return int
     */
    public function getMainCardsValue(): int
    {
        return $this->mainCardsValue;
    }

    /**
     * @return int
     */
    public function getKickerOneValue(): int
    {
        return $this->kickerOneValue;
    }

    /**
     * @return int
     */
    public function getKickerTwoValue(): int
    {
        return $this->kickerTwoValue;
    }

    /**
     * @return int
     */
    public function getKickerThreeValue(): int
    {
        return $this->kickerThreeValue;
    }

    /**
     * @return int
     */
    public function getKickerFourValue(): int
    {
        return $this->kickerFourValue;
    }

    /**
     * Verifies if the current rank beats the compared one
     *
     * @param PokerRanking $pokerRank
     * @return bool
     */
    public function beats(PokerRanking $pokerRank): bool
    {
        if ($this->getRankingValue() === $pokerRank->getRankingValue()) {
            if ($this->getMainCardsValue() === $pokerRank->getMainCardsValue()) {
                if ($this->getKickerOneValue() === $pokerRank->getKickerOneValue()) {
                    if ($this->getKickerTwoValue() === $pokerRank->getKickerTwoValue()) {
                        if ($this->getKickerThreeValue() === $pokerRank->getKickerThreeValue()) {
                            if ($this->getKickerFourValue() === $pokerRank->getKickerFourValue()) {
                                return false;
                            }
                            return $this->getKickerFourValue() > $pokerRank->getKickerFourValue();
                        }
                        return $this->getKickerThreeValue() > $pokerRank->getKickerThreeValue();
                    }
                    return $this->getKickerTwoValue() > $pokerRank->getKickerTwoValue();
                }
                return $this->getKickerOneValue() > $pokerRank->getKickerOneValue();
            }
            return $this->getMainCardsValue() > $pokerRank->getMainCardsValue();
        }
        return $this->getRankingValue() > $pokerRank->getRankingValue();
    }


}