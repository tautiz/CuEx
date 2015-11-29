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

/**
 * Exception thrown when a currency code is invalid.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
class InvalidCurrencyCodeException extends Exception
{
    public function __construct($currencyCode)
    {
        parent::__construct(sprintf('The currency code "%s" is invalid', $currencyCode));
    }
}
