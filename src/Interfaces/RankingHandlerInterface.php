<?php


namespace SmaatCoda\PokerRankr\Interfaces;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\PokerRanking;

interface RankingHandlerInterface
{
    /**
     * @param PokerHand $hand
     * @return PokerRanking
     */
    public function handle(PokerHand $hand): PokerRanking;

    /**
     * @param PokerHand $hand
     * @return PokerRanking
     */
    public function next(PokerHand $hand): PokerRanking;

    /**
     * @param RankingHandlerInterface $handler
     */
    public function setSuccessor(RankingHandlerInterface $handler): void;
}