<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Entities;

use SmaatCoda\PokerRankr\Exceptions\Exception;
use SmaatCoda\PokerRankr\Interfaces\EntityInterface;

class PokerCard implements EntityInterface
{
    public const SUIT_DIAMONDS = '♦';
    public const SUIT_HEARTS   = '♥';
    public const SUIT_SPADES   = '♠';
    public const SUIT_CLUBS    = '♣';

    public const RANK_LOWER_ACE = 1;
    public const RANK_TWO       = 2;
    public const RANK_THREE     = 3;
    public const RANK_FOUR      = 4;
    public const RANK_FIVE      = 5;
    public const RANK_SIX       = 6;
    public const RANK_SEVEN     = 7;
    public const RANK_EIGHT     = 8;
    public const RANK_NINE      = 9;
    public const RANK_TEN       = 10;
    public const RANK_JACK      = 11;
    public const RANK_QUEEN     = 12;
    public const RANK_KING      = 13;
    public const RANK_ACE       = 14;

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

    protected static $allowedSuits = [
        self::SUIT_DIAMONDS,
        self::SUIT_HEARTS,
        self::SUIT_SPADES,
        self::SUIT_CLUBS,
    ];

    /**
     * @var int
     */
    protected $rank;

    /**
     * @var string
     */
    protected $suit;

    /**
     * PokerCard constructor.
     *
     * @param int $rank
     * @param string $suit
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
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }

    /**
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * @param string $suit
     */
    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }


    public function toArray(): array
    {
        return [
            'rank' => $this->rank,
            'suit' => $this->suit,
        ];
    }

    /**
     * @param array $data
     * @return PokerCard
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