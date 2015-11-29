<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Cache;

use Doctrine\Common\Cache\Cache;
use CuEx\CacheInterface;
use CuEx\Model\CurrencyPair;
use CuEx\Model\Rate;
use CuEx\Model\Provider;

/**
 * DoctrineCache implementation.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class DoctrineCache implements CacheInterface
{
    private $cache;
    private $ttl;

    /**
     * Creates a new cache.
     *
     * @param Cache   $cache The cache
     * @param integer $ttl   The ttl in seconds
     */
    public function __construct(Cache $cache, $ttl = 0)
    {
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchRate(CurrencyPair $currencyPair)
    {
        $rate = $this->cache->fetch($currencyPair->toString());

        return false === $rate ? null : $rate;
    }

    /**
     * {@inheritdoc}
     */
    public function storeRate(CurrencyPair $currencyPair, Rate $rate)
    {
        $this->cache->save($currencyPair->toString(), $rate, $this->ttl);
    }
}
