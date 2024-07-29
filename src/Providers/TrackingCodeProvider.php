<?php

namespace GoogleAdsConversionTracking\Providers;

use Plenty\Modules\Frontend\Session\Storage\Contracts\FrontendSessionStorageFactoryContract;
use Plenty\Plugin\Templates\Twig;


class TrackingCodeProvider
{
    public function call( Twig $twig )
    {
        return $twig->render(
            'GoogleAdsConversionTracking::GoogleAdsConversionTrackingTrackingCode'
        );
    }
}
