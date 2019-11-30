<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use SmaatCoda\PokerRankr\Exceptions\Exception;
use SmaatCoda\PokerRankr\Interfaces\EntityInterface;

/**
 * Class PokerCard
 *
 * @package SmaatCoda\PokerRankr\Entities
 */
class PokerCard implements EntityInterface
{
    /**
     * @var string Poker card suit string.
     */
    public const SUIT_DIAMONDS = '♦';

    /**
     * @var string Poker card suit string.
     */
    public const SUIT_HEARTS = '♥';

    /**
     * @var string Poker card suit string.
     */
    public const SUIT_SPADES = '♠';

    /**
     * @var string Poker card suit string
     */
    public const SUIT_CLUBS = '♣';


    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_LOWER_ACE = 1;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_TWO = 2;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_THREE = 3;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_FOUR = 4;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_FIVE = 5;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_SIX = 6;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_SEVEN = 7;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_EIGHT = 8;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_NINE = 9;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_TEN = 10;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_JACK = 11;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_QUEEN = 12;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_KING = 13;

    /**
     * @var int Poker card rank, numeric representation.
     */
    public const RANK_ACE = 14;

    /**
     * @var array A list of valid card rank numeric values.
     */
    protected static $allowedRanks = [
        self::RANK_LOWER_ACE,
        self::RANK_TWO,
        self::RANK_THREE,
        self::RANK_FOUR,
        self::RANK_FIVE,
        self::RANK_SIX,
        self::RANK_SEVEN,
        self::RANK_EIGHT,
        self::RANK_NINE,
        self::RANK_TEN,
        self::RANK_JACK,
        self::RANK_QUEEN,
        self::RANK_KING,
        self::RANK_ACE,
    ];

    /**
     * @var array A list of valid card suits.
     */
    protected static $allowedSuits = [
        self::SUIT_DIAMONDS,
        self::SUIT_HEARTS,
        self::SUIT_SPADES,
        self::SUIT_CLUBS,
    ];

    /**
     * @var int Card rank numeric representation.
     */
    protected $rank;

    /**
     * @var string Card suit.
     */
    protected $suit;

    /**
     * PokerCard constructor.
     *
     * @param int $rank Card rank numeric representation.
     * @param string $suit Card suit
     *
     * @throws Exception
     */
    public function __construct(int $rank, string $suit)
    {
        if (!in_array($rank, self::$allowedRanks, false)) {
            throw new Exception("'$rank' is not a valid rank value!");
        }

        if (!in_array($suit, self::$allowedSuits, false)) {
            throw new Exception("'$suit' is not a valid rank value!");
        }

        $this->rank = $rank;
        $this->suit = $suit;
    }

    /**
     * Returns the card's rank.
     *
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * Sets the card's rank.
     *
     * @param int $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    /**
     * Returns the card's suit.
     *
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Sets the card's suit.
     *
     * @param string $suit
     */
    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    /**
     * Converts PokerCard to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'suit' => $this->suit,
        ];
    }

    /**
     * Instantiates a new PokerCard from an array.
     *
     * @param array $data
     *
     * @return PokerCard
     *
     * @throws Exception
     */
    public static function fromArray(array $data): PokerCard
    {
        if (!isset($data['suit'])) {
            throw new Exception('Failed to construct PokerCard, suit is missing!');
        }

        if (!isset($data['rank'])) {
            throw new Exception('Failed to construct PokerCard, rank is missing!');
        }

        return new PokerCard($data['rank'], $data['suit']);
    }
}