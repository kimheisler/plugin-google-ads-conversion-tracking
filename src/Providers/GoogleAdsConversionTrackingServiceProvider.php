<?php // strict

namespace GoogleAdsConversionTracking\Providers;

use Plenty\Modules\Frontend\Session\Storage\Contracts\FrontendSessionStorageFactoryContract;
use Plenty\Modules\Order\Events\OrderCreated;
use Plenty\Modules\Webshop\Consent\Contracts\ConsentRepositoryContract;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

/**
 * Class IOServiceProvider
 * @package IO\Providers
 */
class GoogleAdsConversionTrackingServiceProvider extends ServiceProvider
{
    /**
     * Register the core functions
     */
    public function register()
    {
        /** @var ConsentRepositoryContract $consentRepository */
        $consentRepository = pluginApp(ConsentRepositoryContract::class);
        $consentRepository->registerConsent(
            'GoogleAdsConversionTracking',
            'GoogleAdsConversionTracking::GoogleAdsConversionTracking.consentLabel',
            function() {
                /** @var ConfigRepository $config */
                $config = pluginApp(ConfigRepository::class);
                return  [
                    'description' => 'GoogleAdsConversionTracking::GoogleAdsConversionTracking.consentDescription',
                    'provider' => 'GoogleAdsConversionTracking::GoogleAdsConversionTracking.consentProvider',
                    'lifespan' => 'GoogleAdsConversionTracking::GoogleAdsConversionTracking.consentLifespan',
                    'policyUrl' => 'GoogleAdsConversionTracking::GoogleAdsConversionTracking.consentPolicyUrl',
                    'group' => $config->get('GoogleAdsConversionTracking.consentGroup', 'tracking'),
                    'necessary' => $config->get('GoogleAdsConversionTracking.consentNecessary') === 'true',
                    'isOptOut' => $config->get('GoogleAdsConversionTracking.consentOptOut') === 'true',
                    'cookieNames' => ['/^_gsas/','_eoi', '_gads', '_gcl_dc']
                ];
            }
        );
    }

    /**
     * boot twig extensions and services
     * @param Twig $twig
     * @param Dispatcher $dispatcher
     */
    public function boot(Twig $twig, Dispatcher $dispatcher)
    {
        $dispatcher->listen(OrderCreated::class, function($event)
        {
            /** @var FrontendSessionStorageFactoryContract $sessionStorage */
            $sessionStorage = pluginApp(FrontendSessionStorageFactoryContract::class);
            $sessionStorage->getPlugin()->setValue('GA_TRACK_ORDER', 1);
        }, 0);
    }
}
