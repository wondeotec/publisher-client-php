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

use EBC\PublisherClient\Campaign\CampaignFilter;
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
    public function getCampaignListApproval($campaignId, $listExternalId)
    {
        return $this->client->getCommand(
            'getCampaignListApproval',
            array('campaignId' => $campaignId, 'listExternalId' => $listExternalId)
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
     * @param int $campaignId
     *
     * @return CampaignFilter
     */
    public function getCampaignsFilters($campaignId)
    {
        return $this->client->getCommand(
            'getCampaignsFilters',
            array(
                'campaignId'  => $campaignId
            )
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListsDefinition()
    {
        return $this->client->getCommand(
            'getListsDefinition'
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListDefinitionByExternalId($externalId)
    {
        return $this->client->getCommand(
            'getListDefinitionByExternalId',
            array('externalId' => $externalId)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function updateListDefinition(
        $externalId,
        $newExternalId,
        $name,
        $description,
        $fromName,
        $publicName,
        $listTemplateId,
        $approvalRulesId,
        array $approvalCategories,
        array $minPayoutParentCategories,
        array $minPayoutChildCategories
    ) {
        return $this->client->getCommand(
            'updateListDefinitionByExternalId',
            array(
                'externalId' => $externalId,
                'list_definition_update' => array(
                    'externalId' => $newExternalId,
                    'name' => $name,
                    'description' => $description,
                    'fromName' => $fromName,
                    'publicName' => $publicName,
                    'listTemplateId' => $listTemplateId,
                    'approvalRulesId' => $approvalRulesId,
                    'approvedCategories' => $approvalCategories,
                    'minPayoutParentCategories' => json_encode($minPayoutParentCategories),
                    'minPayoutChildCategories' => json_encode($minPayoutChildCategories),
                )
            )
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListsApprovalExceptions()
    {
        return $this->client->getCommand(
            'getListsApprovalExceptions'
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListApprovalExceptionsByExternalId($externalId)
    {
        return $this->client->getCommand(
            'getListApprovalExceptionsByExternalId',
            array('externalId' => $externalId)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function updateListApprovalExceptions($externalId, array $approved, array $rejected)
    {
        return $this->client->getCommand(
            'updateListApprovalExceptions',
            array(
                'externalId' => $externalId,
                'list_approval_exceptions_update' => array(
                    'approved' => $approved,
                    'rejected' => $rejected,
                )
            )
        )->execute();
    }
}
