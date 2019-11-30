<?php declare(strict_types=1);

namespace SmaatCoda\PokerRankr\Tests;


use SmaatCoda\PokerRankr\PokerRankrServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package SmaatCoda\PokerRankr\Testso
 */
class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        return [
            PokerRankrServiceProvider::class
        ];
    }
}
