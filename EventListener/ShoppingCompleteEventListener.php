<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\MailChimpAddContact\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;
use Plugin\MailChimpAddContact\Repository\ConfigRepository;

class ShoppingCompleteEventListener implements EventSubscriberInterface
{

    protected $configRepository;
    
    public function __construct(
        ConfigRepository $configRepository
    ) {
        $this->configRepository = $configRepository;
    }

    public function onShoppingComplete(EventArgs $event )
    {
        $Config = $this->configRepository->get();
        $server_prefix = $Config->getServerPrefix();
        $api_key = $Config->getApiKey();
        $list_id = $Config->getListId();
        $Order = $event->getArgument('Order');

        $fields = array(
            "email_address" => $Order->getEmail(),
            "status" => "subscribed",
            "merge_fields" => [
                "FNAME" => $Order->getName01(),
                "LNAME" => $Order->getName02()
            ]
        );

        $ch = curl_init("https://{$server_prefix}.api.mailchimp.com/3.0/lists/{$list_id}/members");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $api_key ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields) );

        $response = curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EccubeEvents::FRONT_SHOPPING_COMPLETE_INITIALIZE => ['onShoppingComplete', 7],
        ];
    }
}
