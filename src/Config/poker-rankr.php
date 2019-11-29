<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PokerRankr Ranking Handlers definition
    |--------------------------------------------------------------------------
    |
    */
    'default' => 'texas-holdem',

    'texas-holdem' => [
        // Order is not to be changed
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\RoyalFlushHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\StraightFlushHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\FourOfKindHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\FullHouseHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\FlushHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\StraightHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\ThreeOfKindHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\TwoPairsHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\PairHandler::class,
        \SmaatCoda\PokerRankr\RankingHandlers\TexasHoldemHandlers\HighCardHandler::class,
    ]

];
