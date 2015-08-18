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
    public function getCampaignListApproval($campaignId, $listId)
    {
        return $this->client->getCommand(
            'getCampaignListApproval',
            array('campaignId' => $campaignId, 'listId' => $listId)
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
    public function getCampaignsCount(
        EBDateTime $endDateGreaterThan = null,
        $country = null,
        $parentCategory = null,
        $campaignNamePattern = null
    ) {
        if ($endDateGreaterThan instanceof EBDateTime) {
            $endDateGreaterThan = $endDateGreaterThan->formatAsDateString();
        }

        try {
            return $this->client->getCommand(
                'getCampaignsCount',
                array(
                    'endDateGreaterThan' => $endDateGreaterThan,
                    'country' => $country,
                    'parentCategory' => $parentCategory,
                    'campaignNamePattern' => $campaignNamePattern,
                )
            )->execute();
        } catch (\Exception $exception) {

            // @TODO an object containing the errors should be returned
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCampaigns(
        $orderField,
        $orderDirection,
        EBDateTime $endDateGreaterThan = null,
        $country = null,
        $parentCategory = null,
        $campaignNamePattern = null,
        $page = null,
        $pageResultsNumber = null
    ) {
        if ($endDateGreaterThan instanceof EBDateTime) {
            $endDateGreaterThan = $endDateGreaterThan->formatAsDateString();
        }

        try {
            return $this->client->getCommand(
                'getCampaigns',
                array(
                    'orderField' => $orderField,
                    'orderDirection' => $orderDirection,
                    'endDateGreaterThan' => $endDateGreaterThan,
                    'country' => $country,
                    'parentCategory' => $parentCategory,
                    'campaignNamePattern' => $campaignNamePattern,
                    'page' => $page,
                    'pageResultsNumber' => $pageResultsNumber,
                )
            )->execute();
        } catch (\Exception $exception) {

            // @TODO an object containing the errors should be returned
            return false;
        }
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
    public function getListById($id)
    {
        return $this->client->getCommand(
            'getListById',
            array('id' => $id)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function updateList(
        $id,
        $name,
        $description,
        $fromName,
        $publicName,
        $listTemplateId,
        $approvalRulesId,
        array $approvalCategories,
        array $minPayoutParentCategories,
        array $minPayoutChildCategories,
        $isEnabledForCPMBidding
    ) {
        return $this->client->getCommand(
            'updateListById',
            array(
                'id' => $id,
                'list_definition_update' => array(
                    'name' => $name,
                    'description' => $description,
                    'fromName' => $fromName,
                    'publicName' => $publicName,
                    'listTemplateId' => $listTemplateId,
                    'approvalRulesId' => $approvalRulesId,
                    'approvedCategories' => $approvalCategories,
                    'minPayoutParentCategories' => json_encode($minPayoutParentCategories),
                    'minPayoutChildCategories' => json_encode($minPayoutChildCategories),
                    'isEnabledForCPMBidding' => $isEnabledForCPMBidding
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
    public function getListApprovalExceptionsById($id)
    {
        return $this->client->getCommand(
            'getListApprovalExceptionsById',
            array('id' => $id)
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function updateListApprovalExceptions($id, array $approved, array $rejected)
    {
        return $this->client->getCommand(
            'updateListApprovalExceptions',
            array(
                'id' => $id,
                'list_approval_exceptions_update' => array(
                    'approved' => $approved,
                    'rejected' => $rejected,
                )
            )
        )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function getListStats()
    {
        return $this->client->getCommand(
            'getListStats'
        )->execute();
    }
}
