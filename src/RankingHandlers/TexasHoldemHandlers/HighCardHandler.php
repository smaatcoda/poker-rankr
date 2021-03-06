<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class HighCardHandler
 *
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class HighCardHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    /**
     * @inheritDoc
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        $ranks = $this->extractRanks($hand);

        // Sort biggest to smallest, use as kickers
        rsort($ranks);

        $rankingValue = PokerRanking::HIGH_CARD;

        return new PokerRanking($rankingValue, ...$ranks);
    }
}