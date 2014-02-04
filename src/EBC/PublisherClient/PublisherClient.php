<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient;

use EBT\Fastc\Client as FastcClient;
use EBT\Fastc\Listener\StatusCodeListener;
use EBT\Fastc\Listener\ParseResponseListener;

/**
 * PublisherClient
 */
class PublisherClient extends FastcClient
{
    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        parent::__construct(
            $this->getServiceDescription(__DIR__ . '/Resources/config/api_services.yml'),
            array_merge($this->readYaml(__DIR__ . '/Resources/config/client_config.yml'), $config)
        );

        $this->addSubscriber(new StatusCodeListener());
        $this->addSubscriber(
            new ParseResponseListener(
                $this->getSerializer(__DIR__ . '/Resources/config/serializer', 'EBC\PublisherClient')
            )
        );
    }

    /**
     * @param int    $publisherId
     * @param string $key
     * @param string $secret
     *
     * @return $this
     */
    public function publisher($publisherId, $key, $secret)
    {
        $this->client->getConfig()->setPath('publisherId', $publisherId)
                                  ->setPath('request.options/query/key', $key)
                                  ->setPath('request.options/query/secret', $secret);

        return $this;
    }

    /**
     * @param null $orderBy
     * @param null $order
     *
     * @return mixed
     */
    public function getCampaigns($orderBy = null, $order = null)
    {
        return $this->client->getCommand(
            'getCampaigns',
            array('orderBy' => $orderBy, 'order' => $order)
        )->execute();
    }
}
