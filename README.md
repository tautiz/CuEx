# CuEx

> Currency Exchange rates library for PHP

## Installation

```bash
$ composer require tautiz/CuEx
```

Add service to App providers array:

```
CuEx\CuExServiceProvider::class,
```


## Usage

Create an HTTP adapter
```php
$httpAdapter = new \Ivory\HttpAdapter\FileGetContentsHttpAdapter();
```

Then, you can create a provider and add it to CuEx:

```php
// Create the Yahoo Finance provider
$provider = new \CuEx\Provider\YahooFinanceProvider($httpAdapter);

// Create CuEx with the provider
$cuex = new \CuEx\CuEx($provider);
```

### Quoting

To retrieve the latest exchange rate for a currency pair, you need to use the `quote()` method.

```php
$rate = $cuex->getRate('EUR/LTL');

// 3.4528
echo $rate;

// 3.4528
echo $rate->getValue();

// 15-11-28 23:59:59
echo $rate->getDate()->format('Y-m-d H:i:s');
```

> Currencies are expressed as their [ISO 4217](http://en.wikipedia.org/wiki/ISO_4217) code.

### Chaining providers

It is possible to chain providers in order to use fallbacks in case the main providers don't support the currency or are unavailable.
Simply create a `ChainProvider` wrapping the providers you want to chain.

```php
$chainProvider = new \CuEx\Provider\ChainProvider([
    new \CuEx\Provider\YahooFinanceProvider($httpAdapter),
    new \CuEx\Provider\CurrencylayerProvider($httpAdapter,'<YOUR_ACCESS_KEY>'),
    new \CuEx\Provider\FixerProvider($httpAdapter),
    new \CuEx\Provider\GoogleFinanceProvider($httpAdapter),
]);
```

The rates will be first fetched using the Yahoo Finance provider and will fallback to Google Finance.

### Caching

For performance reasons you might want to cache the rates during a given time.

#### Doctrine Cache

##### Installation

```bash
$ composer require doctrine/cache
```

##### Usage

```php
// Create the cache adapter
$cache = new \CuEx\Cache\DoctrineCache(new \Doctrine\Common\Cache\ApcCache(), 3600);

// Pass the cache to CuEx
$cuex = new \CuEx\CuEx($provider, $cache);
```

All rates will now be cached to 3600 minutes.


### Currency Codes

CuEx provides an enumeration of currency codes so you can use autocompletion to avoid typos.

```php
use \CuEx\Util\CurrencyCodes;

// Retrieving the EUR/LTL rate
$rate = $cuex->quote(new \CuEx\Model\CurrencyPair(
    CurrencyCodes::ISO_EUR,
    CurrencyCodes::ISO_LTL
));
```

## License

[MIT](https://github.com/tautiz/cuex/blob/master/LICENSE)