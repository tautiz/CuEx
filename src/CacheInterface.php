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
use CuEx\Model\Rate;
use CuEx\Model\Provider;

/**
 * Contract for caches.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
interface CacheInterface
{
    /**
     * Fetches the rate.
     *
     * @param CurrencyPair $currencyPair
     *
     * @return Rate|null
     */
    public function fetchRate(CurrencyPair $currencyPair);

    /**
     * Stores the rate.
     *
     * @param CurrencyPair $currencyPair
     * @param Rate         $rate
     * @param Provider     $provider
     */
    public function storeRate(CurrencyPair $currencyPair, Rate $rate);
}
