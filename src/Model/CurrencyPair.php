<?php

/*
 * This file is part of CuEx.
 *
 * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CuEx\Model;

/**
 * Represents a currency pair.
 *
 * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
 */
final class CurrencyPair
{
    private $baseCurrency;
    private $quoteCurrency;

    /**
     * Creates a new currency pair.
     *
     * @param string $baseCurrency  The base currency ISO 4217 code.
     * @param string $quoteCurrency The getRate currency ISO 4217 code.
     */
    public function __construct($baseCurrency, $quoteCurrency)
    {
        $this->baseCurrency = $baseCurrency;
        $this->quoteCurrency = $quoteCurrency;
    }

    /**
     * Creates a currency pair from a string.
     *
     * @param string $string A string in the form EUR/USD
     *
     * @return CurrencyPair
     *
     * @throws \InvalidArgumentException
     */
    public static function createFromString($string)
    {
        $parts = explode('/', $string);

        if (!isset($parts[0]) || 3 !== strlen($parts[0]) || !isset($parts[1]) || 3 !== strlen($parts[1])) {
            throw new \InvalidArgumentException('The currency pair must be in the form "EUR/USD".');
        }

        return new self($parts[0], $parts[1]);
    }

    /**
     * Gets the base currency.
     *
     * @return string
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * Gets the getRate currency.
     *
     * @return string
     */
    public function getQuoteCurrency()
    {
        return $this->quoteCurrency;
    }

    /**
     * Returns a string representation of the pair.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf('%s/%s', $this->baseCurrency, $this->quoteCurrency);
    }

    /**
     * Returns a string representation of the pair.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
