<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class RoyalFlushHandler
 *
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class RoyalFlushHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    /**
     * @inheritDoc
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        $suits = $this->extractSuits($hand);

        // Count occurrences for each suit value
        $occurrences = array_count_values($suits);

        // Check if all 5 cards are of the same suit
        if (!in_array(5, $occurrences, false)) {
            return $this->next($hand);
        }

        $ranks = $this->extractRanks($hand);

        $ranksConsecutive = $this->checkConsecutiveRanks($ranks);

        if (!$ranksConsecutive) {
            return $this->next($hand);
        }

        $endsWithAce = max($ranks) === PokerCard::RANK_ACE;

        if (!$endsWithAce) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::ROYAL_FLUSH;
        $mainCardsValue = array_sum($ranks);

        return new PokerRanking($rankingValue, $mainCardsValue);
    }
}