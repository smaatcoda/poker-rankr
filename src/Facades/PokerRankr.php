<?php

namespace SmaatCoda\PokerRankr\Facades;

use Illuminate\Support\Facades\Facade;
use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Entities\PokerHandCollection;

/**
 * Class PokerRankr
 *
 * @method static PokerHand evaluateHand(PokerHand $hand) Determines a hand's ranking and stores it as the hand's property
 * @method static PokerHand evaluateHands(PokerHandCollection $hands) Determines hands' rankings for each hand in a collection
 * @method static PokerHand sortHands(PokerHandCollection $hands) Sorts hands in a collection according to their rankings
 *
 * @package SmaatCoda\PokerRankr\Facades
 */
class PokerRankr extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'PokerRankr';
    }
}
