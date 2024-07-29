<?php

namespace GoogleAdsConversionTracking\Providers;

use Plenty\Modules\Frontend\Session\Storage\Contracts\FrontendSessionStorageFactoryContract;
use Plenty\Plugin\Templates\Twig;


class PurchaseEventCodeProvider
{
    public function call( Twig $twig )
    {
        /** @var FrontendSessionStorageFactoryContract $sessionStorage */
        $sessionStorage = pluginApp(FrontendSessionStorageFactoryContract::class);

        $enableTracking = $sessionStorage->getPlugin()->getValue('GA_TRACK_ORDER') === 1;

        $sessionStorage->getPlugin()->unsetKey('GA_TRACK_ORDER');

        return $twig->render(
            'GoogleAdsConversionTracking::GoogleAdsConversionTrackingPurchaseEventCode',
            [
                'trackOrder' => $enableTracking
            ]
        );
    }
}
