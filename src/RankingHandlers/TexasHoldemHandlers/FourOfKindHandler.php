<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class FourOfKindHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        if (!in_array(4, $occurrences, false)) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::FOUR_OF_KIND;
        $mainCardsValue = array_search(4, $occurrences, false);
        $kickerOneValue = array_search(1, $occurrences, false);

        return new PokerRanking($rankingValue, $mainCardsValue, $kickerOneValue);
    }
}