### PokerRankr - a poker hand ranking engine.
The package can be installed by running the following command: 

`composer require smaatcoda/poker-rankr`

#### Installed in a Laravel-based app?
If installed in a Laravel-based application, feel free to leverage
Laravel's service container and Facades. To do that, add to your `config/app.php` 
file:
* PokerRankrServiceProvider:\
`\SmaatCoda\PokerRankr\PokerRankrServiceProvider::class`
* PokerRankr Facade:\
`'PokerRankr' => SmaatCoda\PokerRankr\Facades\PokerRankr::class`

After doing so run `php artisan vendor:publish --tag=poker-rankr-config`
to copy PokerRankr config file to your project.

Now you can instantiate `PokerRankr` using Laravel's service container 
like so:

```$xslt
...

$ranker = app()->make(PokerRankr::class);
$ranker->evaluateHand($hand);
```

or so:

```$xslt
public function index(PokerRankr $ranker)
{
    ...

    $ranker->evaluateHand($hand);
}
```

Also you can use PokerRankr facade:

```$xslt
...

PokerRankr::evaluateHand($hand);
```

#### Installed in a plain PHP app?
If installed in a non-Laravel application, you can instantiate `PokerRankr`
by first instantiating `PokerRankr` Config and passing a set of handlers to 
`PokerRankr` constructor like so:

```$xslt
...

$config = new Config();
$ranker = new PokerRankr($config->get('texas-holdem'));

$ranker->evaluateHand($hand);
```
#### Usage
Use PokerRankr to evaluate rankings of poker hands or to sort collections
of poker hands. PokerCard entity provides a set of constants for each
of common playing card ranks and suits
for a proper instantiation of a PokerCard object.
```$xslt
$hand = new PokerHand();
$hand->add(new PokerCard(PokerCard::RANK_ACE, PokerCard::SUIT_DIAMONDS));
$hand->add(new PokerCard(PokerCard::RANK_KING, PokerCard::SUIT_DIAMONDS));
$hand->add(new PokerCard(PokerCard::RANK_JACK, PokerCard::SUIT_DIAMONDS));
$hand->add(new PokerCard(PokerCard::RANK_QUEEN, PokerCard::SUIT_DIAMONDS));
$hand->add(new PokerCard(PokerCard::RANK_TEN, PokerCard::SUIT_DIAMONDS));
``` 
After making a collection of poker hands you can use `PokerRankr` to
sort the hands in the collection, such that afterwards the first hand in 
it will be the winning hand.
```$xslt
...

$handsCollection = new PokerHandCollection($hand2, $hand1);

$ranker->sortHands($handsCollection);

$winnerHand = $handsCollection->first();
```
#### Customization
You can write your own set of RankingHandlers as long as they implement `RankingHandlerInterface`.
