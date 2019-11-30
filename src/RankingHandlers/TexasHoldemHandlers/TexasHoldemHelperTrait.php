<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;

/**
 * Trait TexasHoldemHandlerTrait
 *
 * @package PokerRankr\PokerRankr\RankingHandlers\TexasHoldemHandlers
 */
trait TexasHoldemHelperTrait
{
    /**
     * Determines whether or not an array contains strictly consecutive ranks (n, n+1, n+2).
     *
     * @param $ranks
     * @return bool
     */
    public function checkConsecutiveRanks($ranks): bool
    {
        $result = true;

        sort($ranks);

        for ($index = 0; $index < count($ranks) - 1; $index++) {
            if (($ranks[$index + 1] - $ranks[$index]) !== 1) {
                $result = false;
                break;
            }
        }

        return $result;
    }

    /**
     * Returns an array of rank values of a hand.
     *
     * @param PokerHand $hand
     * @return array
     */
    public function extractRanks(PokerHand $hand): array
    {
        return $hand->reduce(static function ($array, PokerCard $card) {
            $array[] = $card->getRank();
            return $array;
        }, []);
    }

    /**
     * Returns an array of suit values of a hand.
     *
     * @param PokerHand $hand
     * @return array
     */
    public function extractSuits(PokerHand $hand): array
    {
        return $hand->reduce(static function ($array, PokerCard $card) {
            $array[] = $card->getSuit();
            return $array;
        }, []);
    }
}