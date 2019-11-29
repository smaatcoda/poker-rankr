<?php


namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\RankingHandlers\RankingHandlerTrait;

class FlushHandler implements RankingHandlerInterface
{
    use RankingHandlerTrait;
    use TexasHoldemHelperTrait;

    public function handle(PokerHand $hand): PokerRanking
    {
        $suits = $this->extractSuits($hand);

        $sameSuit = count(array_unique($suits)) === 1;

        if (!$sameSuit) {
            return $this->next($hand);
        }

        $ranks = $this->extractRanks($hand);

        rsort($ranks);

        $rankingValue = PokerRanking::FLUSH;

        return new PokerRanking($rankingValue, ...$ranks);
    }
}