<?php declare(strict_types=1);


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

/**
 * Class FlushHandler
 *
 * @package SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
class FlushHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    /**
     * @inheritDoc
     */
    public function handle(PokerHand $hand): PokerRanking
    {
        $suits = $this->extractSuits($hand);

        // In case of Flush all suits are the same
        $sameSuit = count(array_unique($suits)) === 1;

        if (!$sameSuit) {
            return $this->next($hand);
        }

        $ranks = $this->extractRanks($hand);

        // Sort ranks biggest to smallest to use as kickers
        rsort($ranks);

        $rankingValue = PokerRanking::FLUSH;

        return new PokerRanking($rankingValue, ...$ranks);
    }
}