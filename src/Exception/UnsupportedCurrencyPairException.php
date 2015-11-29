<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Exception;

use CuEx\Model\CurrencyPair;

/**
 * Exception thrown when a currency pair is not supported by a provider.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class UnsupportedCurrencyPairException extends Exception
{
    private $currencyPair;

    public function __construct(CurrencyPair $currencyPair)
    {
        parent::__construct(sprintf('The currency pair "%s" is not supported.', $currencyPair->toString()));
        $this->currencyPair = $currencyPair;
    }

    /**
     * Gets the unsupported currency pair.
     *
     * @return \CuEx\Model\CurrencyPair
     */
    public function getCurrencyPair()
    {
        return $this->currencyPair;
    }
}
