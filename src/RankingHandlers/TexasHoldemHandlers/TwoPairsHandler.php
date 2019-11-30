<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class TwoPairsHandler
 *
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class TwoPairsHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    /**
     * @inheritDoc
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // In case of two pairs a hand will have exactly 3 unique ranks
        $uniqueRanks = array_unique($ranks);

        if (count($uniqueRanks) !== 3) {
            return $this->next($hand);
        }

        // Count occurrences for each rank value
        $occurrences = array_count_values($ranks);

        $rankingValue = PokerRanking::TWO_PAIRS;

        $pairsRanks = [];

        foreach ($occurrences as $rank => $occurrence) {
            if ($occurrence === 2) {
                $pairsRanks[] = $rank;
            } else {
                $kickerTwoValue = $rank;
            }
        }

        rsort($pairsRanks);

        [$mainCardsValue, $kickerOneValue] = $pairsRanks;

        return new PokerRanking($rankingValue, $mainCardsValue, $kickerOneValue, $kickerTwoValue);
    }
}