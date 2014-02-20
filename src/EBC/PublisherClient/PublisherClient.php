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

use EBT\EBDate\EBDateTime;
use EBT\Fastc\Client as FastcClient;
use EBT\Fastc\Listener\StatusCodeListener;
use EBT\Fastc\Listener\ParseResponseListener;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Handler\HandlerRegistry;
use EBT\EBDate\Serializer\EBDateTimeHandler;

/**
 * PublisherClient
 */
class PublisherClient extends FastcClient implements PublisherClientInterface
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
     * {@inheritdoc}
     */
    protected function getSerializer($dir, $namespacePrefix = '')
    {
        return SerializerBuilder::create()
            ->addMetadataDir($dir, $namespacePrefix)
            ->configureHandlers(
                function (HandlerRegistry $registry) {
                    $registry->registerSubscribingHandler(new EBDateTimeHandler());
                }
            )
            ->build();
    }

    /**
     * {@inheritdoc}
     */
    public function setPublisher($publisherId, $key, $secret)
    {
        $this->client->getConfig()->setPath('publisherId', $publisherId)
                                  ->setPath('request.options/query/key', $key)
                                  ->setPath('request.options/query/secret', $secret);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCampaign($campaignId)
    {
        return $this->client->getCommand(
            'getCampaign',
            array('campaignId' => $campaignId)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getCampaignCreativities($campaignId)
    {
        return $this->client->getCommand(
            'getCampaignCreativities',
            array('campaignId' => $campaignId)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getCampaigns(
        $orderBy = null,
        $order = null,
        EBDateTime $endDateGreaterThan = null,
        $country = null,
        $category = null,
        $limit = null
    ) {
        if ($endDateGreaterThan instanceof EBDateTime) {
            $endDateGreaterThan = $endDateGreaterThan->formatAsDateString();
        }

        return $this->client->getCommand(
            'getCampaigns',
            array(
                'orderBy' => $orderBy,
                'order' => $order,
                'endDateGreaterThan' => $endDateGreaterThan,
                'country' => $country,
                'category' => $category,
                'limit' => $limit,
            )
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getLists()
    {
        return $this->client->getCommand(
            'getLists'
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListByExternalId($externalId)
    {
        return $this->client->getCommand(
            'getListByExternalIdAndPublisherAction',
            array('externalId' => $externalId)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function updateListByPublisher($externalId, $name, array $approved, array $rejected)
    {
        $this->client->getCommand(
            'updateListByPublisher',
            array(
                'externalId' => $externalId,
                'list_definition_update' => array(
                    'externalId' => $externalId,
                    'name' => $name,
                    'approved' => implode(',', $approved),
                    'rejected' => implode(',', $rejected),
                )
            )
        )->execute();
    }
}
