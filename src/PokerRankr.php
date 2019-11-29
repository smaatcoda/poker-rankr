<?php

namespace SmaatCoda\PokerRankr;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Entities\PokerHandCollection;
use SmaatCoda\PokerRankr\Exceptions\Exception;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;

/**
 * Class PokerRankr
 * @package SmaatCoda\PokerRankr
 */
class PokerRankr
{
    /**
     * @var RankingHandlerInterface
     */
    protected $lead;

    /**
     * PokerRankr constructor.
     * @param array $handlers
     * @throws Exception
     */
    public function __construct(array $handlers = [])
    {
        if (empty($handlers)) {
            throw new Exception('No ranking handlers provided!');
        }

        /** @var RankingHandlerInterface $previous */
        $previous = null;
        foreach ($handlers as $handler) {
            if ($previous === null) {
                $this->lead = $previous = new $handler();
                continue;
            }
            $handler = new $handler();
            $previous->setSuccessor($handler);
            $previous = $handler;
        }
    }

    /**
     * @param PokerHand $hand
     * @return PokerHand
     * @throws Exception
     */
    public function evaluateHand(PokerHand $hand): PokerHand
    {
        if ($hand->count() !== 5) {
            throw new Exception('Every hand must contain exactly 5 cards!');
        }
        $hand->setRanking($this->lead->handle($hand));

        return $hand;
    }

    /**
     * @param PokerHandCollection $hands
     * @return PokerHandCollection
     * @throws Exception
     */
    public function evaluateHands(PokerHandCollection $hands): PokerHandCollection
    {
        foreach ($hands as $hand) {
            $this->evaluateHand($hand);
        }

        return $hands;
    }

    /**
     * @param PokerHandCollection $hands
     * @return PokerHandCollection
     * @throws Exception
     */
    public function sortHands(PokerHandCollection $hands): PokerHandCollection
    {
        $hands = $this->evaluateHands($hands);

        $hands->sort(function (PokerHand $previous, PokerHand $next) {
            if (!$next->getRanking()) {
                $next = $this->evaluateHand($next);
            }

            if (!$previous->getRanking()) {
                $previous = $this->evaluateHand($previous);
            }

            return $next->getRanking()->beats($previous->getRanking());
        });

        return $hands;
    }

}