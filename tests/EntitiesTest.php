<?php

namespace SmaatCoda\PokerRankr\Tests;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;

/**
 * Class EntitiesTest
 * @package SmaatCoda\PokerRankr\Tests
 */
class EntitiesTest extends TestCase
{
    public function test_instantiate_card()
    {
        $card = new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS);

        $this->assertEquals(PokerCard::RANK_ACE, $card->getRank());
        $this->assertEquals(PokerCard::SUIT_DIAMONDS, $card->getSuit());

        $card->setRank(PokerCard::RANK_KING);
        $card->setSuit(PokerCard::SUIT_HEARTS);

        $this->assertEquals(PokerCard::RANK_KING, $card->getRank());
        $this->assertEquals(PokerCard::SUIT_HEARTS, $card->getSuit());
    }

    public function test_inistantiate_hand()
    {
        $hand = new PokerHand();

        $hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_TWO, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_THREE, PokerCard::SUIT_DIAMONDS));
        $hand->add(new PokerCard(PokerCard::RANK_FOUR, PokerCard::SUIT_HEARTS));

        $this->assertCount(4, $hand);
        $this->assertInstanceOf(PokerCard::class, $hand->first());
    }

}
