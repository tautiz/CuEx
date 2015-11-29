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

    use CuEx\Exception\Exception;
    use CuEx\Exception\UnsupportedCurrencyPairException;
    use CuEx\Model\CurrencyPair;
    use CuEx\Model\Rate;
    use CuEx\Util\StringUtil;

    /**
     * Open Exchange Rates provider.
     *
     * @author Tautvydas Dulskis <tautvydas@dulskis.eu>
     */
    class FixerProvider extends AbstractProvider
    {
        const URL = 'http://api.fixer.io/latest?base=%s&symbols=%s';

        /**
         * {@inheritdoc}
         */
        public function fetchRate(CurrencyPair $currencyPair)
        {
            $url = sprintf(self::URL, $currencyPair->getBaseCurrency(), $currencyPair->getQuoteCurrency());

            $content = $this->fetchContent($url);
            $data = StringUtil::jsonToArray($content);

            if (isset($data['error'])) {
                throw new Exception($data['error']);
            }

            $date = new \DateTime();
            $date->setTimestamp(strtotime($data['date']));

            if ($data['base'] === $currencyPair->getBaseCurrency()
                && isset($data['rates'][$currencyPair->getQuoteCurrency()])
            ) {
                return new Rate((string) $data['rates'][$currencyPair->getQuoteCurrency()], $date, 'Fixer.io');
            }

            throw new UnsupportedCurrencyPairException($currencyPair);
        }
    }