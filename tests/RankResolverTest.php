<?php declare(strict_types=1);

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

        /** @var PokerRankr $ranker */
        $ranker = $this->app->make(PokerRankr::class);
        $ranking = $ranker->evaluateHand($hand);

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $ranking->getValue());
    }

    public function test_rankr_facade()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $ranking->getValue());
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

        $ranking1 = $ranker->evaluateHand($hand1);
        $ranking2 = $ranker->evaluateHand($hand2);

        $this->assertTrue($ranking1->beats($ranking2));
        $this->assertFalse($ranking2->beats($ranking1));
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

        $ranker->sortHands($handsCollection);

        $winnerHand = $handsCollection->first();
        $winnerRanking = $ranker->evaluateHand($winnerHand);

        $this->assertEquals(PokerRanking::ROYAL_FLUSH, $winnerRanking->getValue());
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

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT_FLUSH, $ranking->getValue());

        // Straight flush starting with an Ace
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FOUR, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_DIAMONDS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT_FLUSH, $ranking->getValue());
    }

    public function test_four_of_a_kind_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FOUR_OF_KIND, $ranking->getValue());
    }

    public function test_full_house_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FULL_HOUSE, $ranking->getValue());
    }

    public function test_flush_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_CLUBS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::FLUSH, $ranking->getValue());
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

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT, $ranking->getValue());

        // Straight flush starting with an Ace
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_HEARTS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_FOUR, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_SPADES));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::STRAIGHT, $ranking->getValue());
    }

    public function test_three_of_a_kind_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::THREE_OF_KIND, $ranking->getValue());
    }

    public function test_two_pairs_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::TWO_PAIRS, $ranking->getValue());
    }

    public function test_pair_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::PAIR, $ranking->getValue());
    }

    public function test_high_card_handler()
    {
        $hand = new PokerHand();
        $hand->add(new PokerCard(PokerCard::RANK_NINE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_CLUBS));
        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_SPADES));
        $hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FIVE, PokerCard::SUIT_HEARTS));

        $ranking = PokerRankrFacade::evaluateHand($hand);

        $this->assertEquals(PokerRanking::HIGH_CARD, $ranking->getValue());
    }
}
