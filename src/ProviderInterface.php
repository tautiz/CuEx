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
 * Contract for providers.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
interface ProviderInterface
{
    /**
     * Fetches the rate for the currency pair.
     *
     * @param CurrencyPair $currencyPair
     *
     * @return \CuEx\Model\Rate
     */
    public function fetchRate(CurrencyPair $currencyPair);
}
