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

    use Ivory\HttpAdapter\HttpAdapterInterface;
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
    class CurrencylayerProvider extends AbstractProvider
    {
        const URL = 'http://apilayer.net/api/live?access_key=%s&format=1';

        private $accKey;

        /**
         * Creates a new provider.
         *
         * @param HttpAdapterInterface $httpAdapter The HTTP client
         * @param string               $accKey       The access key.
         */
        public function __construct(HttpAdapterInterface $httpAdapter, $accKey)
        {
            parent::__construct($httpAdapter);

            $this->accKey = $accKey;
        }

        /**
         * {@inheritdoc}
         */
        public function fetchRate(CurrencyPair $currencyPair)
        {
            if ('USD' !== $currencyPair->getBaseCurrency()) {
                throw new UnsupportedCurrencyPairException($currencyPair);
            }

            $url = sprintf(self::URL, $this->accKey);

            $content = $this->fetchContent($url);
            $data = StringUtil::jsonToArray($content);

            if (isset($data['error'])) {
                throw new Exception($data['info']);
            }

            $date = new \DateTime();
            $date->setTimestamp($data['timestamp']);

            if ($data['source'] === $currencyPair->getBaseCurrency()
                && isset($data['quotes']['USD'.$currencyPair->getQuoteCurrency()])
            ) {
                return new Rate((string) $data['quotes']['USD'.$currencyPair->getQuoteCurrency()], $date,'Currencylayer');
            }

            throw new UnsupportedCurrencyPairException($currencyPair);
        }
    }