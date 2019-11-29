<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class PairHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        if (!in_array(2, $occurrences, false)) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::PAIR;
        $mainCardsValue = array_search(2, $occurrences, false);

        for ($i = 1; $i <= 2; $i++) {
            // Remove pairs from the cards and leave only kickers
            $index = array_search($mainCardsValue, $ranks, false);
            unset($ranks[$index]);
        }

        // Reset array keys
        $ranks = array_values($ranks);

        rsort($ranks);

        return new PokerRanking($rankingValue, $mainCardsValue, ...$ranks);
    }
}