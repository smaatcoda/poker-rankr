<?php

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
     * @param mixed $successor
     */
    public function setSuccessor(RankingHandlerInterface $successor): void
    {
        $this->successor = $successor;
    }

    /**
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