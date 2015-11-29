<?php

    /*
     * This file is part of CuEx.
     *
     * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

    namespace CuEx\Provider;

    use CuEx\Exception\ChainProviderException;
    use CuEx\Exception\InternalException;
    use CuEx\Model\CurrencyPair;
    use CuEx\ProviderInterface;

    /**
     * A provider using other providers in a chain.
     *
     * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
     */
    class ChainProvider
        implements ProviderInterface
    {
        private $providers;

        /**
         * Creates a new chain provider.
         *
         * @param ProviderInterface[] $providers
         */
        public function __construct(array $providers)
        {
            $this->providers = $providers;
        }

        /**
         * {@inheritdoc}
         */
        public function fetchRate(CurrencyPair $currencyPair)
        {
            $rez = [];

            $rates = $this->fetchRates($currencyPair);

            /* @var \CuEx\Model\Rate $rate */
            foreach ($rates as $rate) {
                $rez[] = $rate->getValue();
            }

            $key = array_keys($rates, min($rez));

            return $rates[$key[0]];
        }

        /**
         * {@inheritdoc}
         */
        public function fetchRates(CurrencyPair $currencyPair)
        {

            $exceptions = $rates = [];

            foreach ($this->providers as $provider) {
                try {
                    $rates[] = $provider->fetchRate($currencyPair);

                    //return ;
                } catch (\Exception $e) {
                    if ($e instanceof InternalException) {
                        throw $e;
                    }

                    $exceptions[] = $e;
                }
            }

            if (!empty($exceptions)) {
                throw new ChainProviderException($exceptions);
            }

            return $rates;
        }
    }
