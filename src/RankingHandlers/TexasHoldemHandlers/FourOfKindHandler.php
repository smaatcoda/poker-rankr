<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class FourOfKindHandler
 *
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class FourOfKindHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    /**
     * @inheritDoc
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        // Test for the presence of 4 cards of the same rank
        if (!in_array(4, $occurrences, false)) {
            return $this->next($hand);
        }

        $rankingValue   = PokerRanking::FOUR_OF_KIND;
        $mainCardsValue = array_search(4, $occurrences, false);
        $kickerOneValue = array_search(1, $occurrences, false);

        return new PokerRanking($rankingValue, $mainCardsValue, $kickerOneValue);
    }
}