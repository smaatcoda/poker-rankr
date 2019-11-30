<?php declare(strict_types=1);


namespace SmaatCoda\PokerRankr\Interfaces;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\PokerRanking;

interface RankingHandlerInterface
{
    /**
     * Tests a hand for having a specified combination of cards.
     *
     * @param PokerHand $hand
     * @return PokerRanking
     */
    public function handle(PokerHand $hand): PokerRanking;

    /**
     * Delegates handling of a hand to the successor handler.
     *
     * @param PokerHand $hand
     * @return PokerRanking
     */
    public function next(PokerHand $hand): PokerRanking;

    /**
     * Sets the successor handler to which a hand will be passed in case of not detecting a specified combination of cards.
     *
     * @param RankingHandlerInterface $handler
     */
    public function setSuccessor(RankingHandlerInterface $handler): void;
}