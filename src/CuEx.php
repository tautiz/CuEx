<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx;

use CuEx\Model\CurrencyPair;

/**
 * An implementation of CuEx.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class CuEx implements CuExInterface
{
    private $chainProviders;
    private $provider;
    private $cache;

    public function __construct($provider, CacheInterface $cache = null)
    {
        if($provider instanceof \CuEx\ProviderInterface)
            $this->provider = $provider;
        elseif($provider instanceof \CuEx\Provider\ChainProvider)
            $this->chainProviders = $provider;
        else
            throw new \InvalidArgumentException(
                'The Provider must be either instance of a ProviderInterface or a ChainProvider'
            );
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getRate($currencyPair)
    {
        if (is_string($currencyPair)) {
            $currencyPair = CurrencyPair::createFromString($currencyPair);
        } elseif (!$currencyPair instanceof CurrencyPair) {
            throw new \InvalidArgumentException(
                'The currency pair must be either a string or an instance of CurrencyPair'
            );
        }

        /**
         * @TODO: Imti is Cache duomenis
        */
        if (null !== $this->cache && null !== $rate = $this->cache->fetchRate($currencyPair)) {
            return $rate;
        }

        if(isset($this->chainProviders))
            $rate = $this->chainProviders->fetchRate($currencyPair);
        else
            $rate = $this->provider->fetchRate($currencyPair);

        if (null !== $this->cache) {
            $this->cache->storeRate($currencyPair, $rate);
        }

        return $rate;

    }

    public function getRates($currencyPair){
        if (is_string($currencyPair)) {
            $currencyPair = CurrencyPair::createFromString($currencyPair);
        } elseif (!$currencyPair instanceof CurrencyPair) {
            throw new \InvalidArgumentException(
                'The currency pair must be either a string or an instance of CurrencyPair'
            );
        }

        /**
         * @TODO: Imti is Cache duomenis
         */
        if (null !== $this->cache && null !== $rate = $this->cache->fetchRate($currencyPair)) {
            return $rate;
        }

        if(isset($this->chainProviders))
            $rate = $this->chainProviders->fetchRates($currencyPair);
        else
            $rate = $this->provider->fetchRates($currencyPair);

        if (null !== $this->cache) {
            $this->cache->storeRate($currencyPair, $rate);
        }

        return $rate;
    }

}
