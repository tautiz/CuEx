<?php
    /**
     * This file is part of CuEx.
     *
     * (c) Tautvydas Dulskis <tautvydas@dulskis.eu>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

    namespace CuEx;

    class CuExServiceProvider
        extends \Illuminate\Support\ServiceProvider
    {
        /**
         * Indicates if loading of the provider is deferred.
         *
         * @var bool
         */
        protected $defer = false;

        /**
         * Register the service provider.
         *
         * @return void
         */
        public function register()
        {
            $this->app->singleton(
                'CuEx',
                function () {
                    $httpAdapter = new \Ivory\HttpAdapter\FileGetContentsHttpAdapter();

                    $chainProvider = new \CuEx\Provider\ChainProvider(
                        [
                            new \CuEx\Provider\CurrencylayerProvider($httpAdapter,'719c9c8da06045cc83dfb46669e0665c'),
                            new \CuEx\Provider\FixerProvider($httpAdapter),
                            new \CuEx\Provider\YahooFinanceProvider($httpAdapter),
                            new \CuEx\Provider\GoogleFinanceProvider($httpAdapter),
                        ]
                    );

                    return new CuEx($chainProvider);
                }
            );

            $this->app->alias('CuEx', 'CuEx\Cuex');

            $this->app['command.rate.best'] = $this->app->share(
                function ($app) {
                    return new \CuEx\Console\BestRateCommand($app['CuEx']);
                }
            );

            $this->app['command.rate.list'] = $this->app->share(
                function ($app) {
                    return new \CuEx\Console\RateListCommand($app['CuEx']);
                }
            );

            $this->commands(array('command.rate.best', 'command.rate.list'));
        }
    }