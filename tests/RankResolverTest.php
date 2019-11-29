<?php

namespace SmaatCoda\PokerRankr\Tests;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Entities\PokerHandCollection;
use SmaatCoda\PokerRankr\PokerRanking;
use SmaatCoda\PokerRankr\PokerRankr;
use SmaatCoda\PokerRankr\Facades\PokerRankr as PokerRankrFacade;

/**
 * Class RankResolverTest
 * @package SmaatCoda\PokerRankr\Tests
 */
class RankResolverTest extends TestCase
{

    public function test_rankr_service()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        $ranker = $this->app->make(PokerRankr::class);
        $ranker->evaluateHand($hand);

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $hand->getRanking()->getRankingValue());
    }

    public function test_rankr_facade()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $hand->getRanking()->getRankingValue());
    }

    public function test_royal_flush_beats_other_ranking()
    {
        $hand1 = new PokerHand();
        $hand1->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        $hand2 = new PokerHand();
        $hand2->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_CLUBS));

        /** @var PokerRankr $ranker */
        $ranker = $this->app->make(PokerRankr::class);

        $ranker->evaluateHand($hand1);
        $ranker->evaluateHand($hand2);

        $this->assertTrue($hand1->getRanking()->beats($hand2->getRanking()));
        $this->assertFalse($hand2->getRanking()->beats($hand1->getRanking()));
    }

    public function test_poker_hands_sorted()
    {
        $hand1 = new PokerHand();
        $hand1->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand1->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        $hand2 = new PokerHand();
        $hand2->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand2->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_CLUBS));

        $handsCollection = new PokerHandCollection($hand2, $hand1);

        /** @var PokerRankr $ranker */
        $ranker = $this->app->make(PokerRankr::class);

        $ranker->evaluateHands($handsCollection);
        $winnerHand = $handsCollection->first();

        $this->assertNotEquals(PokerRanking::ROYAL_FLUSH, $winnerHand->getRanking()->getRankingValue());

        $ranker->sortHands($handsCollection);
        $winnerHand = $handsCollection->first();

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $winnerHand->getRanking()->getRankingValue());
    }

    public function test_straight_flush_handler()
    {
        // Regular straight flush
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT_FLUSH, $hand->getRanking()->getRankingValue());

        // Straight flush starting with an Ace
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FOUR, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_DIAMONDS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT_FLUSH, $hand->getRanking()->getRankingValue());
    }

    public function test_four_of_a_kind_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FOUR_OF_KIND, $hand->getRanking()->getRankingValue());
    }

    public function test_full_house_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FULL_HOUSE, $hand->getRanking()->getRankingValue());
    }

    public function test_flush_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_CLUBS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FLUSH, $hand->getRanking()->getRankingValue());
    }

    public function test_straight_handler()
    {
        // Regular straight flush
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_HEARTS));
        $hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_SPADES));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT, $hand->getRanking()->getRankingValue());

        // Straight flush starting with an Ace
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_HEARTS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_FOUR, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_SPADES));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT, $hand->getRanking()->getRankingValue());
    }

    public function test_three_of_a_kind_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::THREE_OF_KIND, $hand->getRanking()->getRankingValue());
    }

    public function test_two_pairs_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::TWO_PAIRS, $hand->getRanking()->getRankingValue());
    }

    public function test_pair_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::PAIR, $hand->getRanking()->getRankingValue());
    }

    public function test_high_card_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::HIGH_CARD, $hand->getRanking()->getRankingValue());
    }
}
