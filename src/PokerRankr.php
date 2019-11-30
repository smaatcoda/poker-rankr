<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr;

use SmaatCoda\PokerRankr\Entities\PokerHand;
use SmaatCoda\PokerRankr\Entities\PokerHandCollection;
use SmaatCoda\PokerRankr\Exceptions\Exception;
use SmaatCoda\PokerRankr\Interfaces\RankingHandlerInterface;

/**
 * Class PokerRankr
 *
 * @package SmaatCoda\PokerRankr
 */
class PokerRankr
{
    /**
     * @var RankingHandlerInterface The first handler to be called.
     */
    protected $lead;

    /**
     * PokerRankr constructor.
     *
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
            $interfaces = class_implements($handler);

            if (!isset($interfaces[RankingHandlerInterface::class])) {
                throw new Exception($handler . ' must implement ' . RankingHandlerInterface::class . '!');
            }

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
     * Returns a hand's ranking as well as attaches it to the hand behind the scenes.
     * @param PokerHand $hand
     * @return PokerRanking
     * @throws Exception
     */
    public function evaluateHand(PokerHand $hand): PokerRanking
    {
        if ($hand->count() !== 5) {
            throw new Exception('Every hand must contain exactly 5 cards!');
        }

        return $hand->getRanking() ?: $this->lead->handle($hand);
    }

    /**
     * Sorts hands in a collection according to their rankings (strongest to weakest).
     *
     * @param PokerHandCollection $hands
     *
     * @return PokerHandCollection
     */
    public function sortHands(PokerHandCollection $hands): PokerHandCollection
    {
        $hands->sort(function (PokerHand $previous, PokerHand $next) {
            $previousRanking = $this->evaluateHand($previous);
            $nextRanking     = $this->evaluateHand($next);

            return $nextRanking->beats($previousRanking);
        });

        return $hands;
    }
}