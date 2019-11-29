<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class StraightFlushHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $suits = $this->extractSuits($hand);

        // Count occurrences for each suit value
        $occurrences = array_count_values($suits);

        if (!in_array(5, $occurrences, false)) {
            return $this->next($hand);
        }

        $ranks = $this->extractRanks($hand);

        $ranksConsecutive = $this->checkConsecutiveRanks($ranks);

        if (!$ranksConsecutive) {
            // Check for a straight starting with Ace
            if (!in_array(PokerCard::RANK_ACE, $ranks, false)) {
                return $this->next($hand);
            }

            $aceKey = array_search(PokerCard::RANK_ACE, $ranks, false);

            $ranks[$aceKey] = PokerCard::RANK_LOWER_ACE;

            $ranksConsecutive = $this->checkConsecutiveRanks($ranks);

            if (!$ranksConsecutive) {
                return $this->next($hand);
            }
        }

        $rankingValue   = PokerRanking::STRAIGHT_FLUSH;
        $mainCardsValue = array_sum($ranks);

        return new PokerRanking($rankingValue, $mainCardsValue);
    }
}