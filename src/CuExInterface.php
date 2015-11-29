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

/**
 * Contract for the CuEx service.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
interface CuExInterface
{
    /**
     * Quotes the currency pair.
     *
     * @param \CuEx\Model\CurrencyPair|string
     *
     * @return \CuEx\Model\Rate
     */
    public function getRate($currencyPair);
}
