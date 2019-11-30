<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\RankingHandlers;

use SmaatCoda\PokerRankr\Entities\PokerCard;
use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Exceptions\Exception;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;
use SmaatCoda\PokerRankr\PokerRanking;

trait RankingHandlerTrait
{
    /**
     * @var RankingHandlerInterface
     */
    protected $successor;

    /**
     * Sets the successor handler to which a hand will be passed in case of not detecting a specified combination of cards.
     *
     * @param mixed $successor
     */
    public function setSuccessor(RankingHandlerInterface $successor): void
    {
        $this->successor = $successor;
    }

    /**
     * Delegates handling of a hand to the successor handler.
     *
     * @param PokerHand $hand
     * @return PokerRanking
     * @throws Exception
     */
    public function next(PokerHand $hand): PokerRanking
    {
        if (!$this->successor) {
            throw new Exception('No lower handler provided!');
        }

        return $this->successor->handle($hand);
    }
}