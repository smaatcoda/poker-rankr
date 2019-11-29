<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class ThreeOfKindHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        if (!in_array(3, $occurrences, false)) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::THREE_OF_KIND;
        $mainCardsValue = array_search(3, $occurrences, false);

        for ($i = 1; $i <= 3; $i++) {
            // Remove the cards of the triplet and leave only kickers
            $index = array_search($mainCardsValue, $ranks);
            unset($ranks[$index]);
        }

        // Reset array keys
        $ranks = array_values($ranks);

        rsort($ranks);

        return new PokerRanking($rankingValue, $mainCardsValue, ...$ranks);
    }
}