<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class FullHouseHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        if (!(in_array(3, $occurrences, false) && in_array(2, $occurrences, false))) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::FULL_HOUSE;
        $mainCardsValue = array_search(3, $occurrences, false);
        $kickerOneValue = array_search(2, $occurrences, false);

        return new PokerRanking($rankingValue, $mainCardsValue, $kickerOneValue);
    }
}