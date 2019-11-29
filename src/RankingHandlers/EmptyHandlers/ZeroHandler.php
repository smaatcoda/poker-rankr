<?php

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class ZeroHandler
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class ZeroHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;

    /**
     * @param PokerHand $hand
     * @return PokerRanking
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        return new PokerRanking(0, 0);
    }
}