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

use EBC\PublisherClient\Campaign\CampaignCount;
use EBC\PublisherClient\Campaign\CampaignsCount;
use EBC\PublisherClient\Campaign\Creativities;
use EBC\PublisherClient\PublisherList\PublisherList;
use EBC\PublisherClient\PublisherList\PublisherLists;
use EBC\PublisherClient\PublisherList\PublisherListsStats;
use EBT\EBDate\EBDateTime;
use EBT\Fastc\ClientInterface;
use EBC\PublisherClient\Campaign\Campaigns;
use EBC\PublisherClient\Campaign\Campaign;
use EBC\PublisherClient\Campaign\Approval;
use EBC\PublisherClient\ListApprovalExceptions\ListApprovalExceptions;
use EBC\PublisherClient\ListApprovalExceptions\ListsApprovalExceptions;

/**
 * PublisherClientInterface
 */
interface PublisherClientInterface extends ClientInterface
{
    const CAMPAIGN_ORDER_BY_FIELD_NAME = 'name';
    const CAMPAIGN_ORDER_BY_FIELD_START_DATE = 'start_date';
    const CAMPAIGN_ORDER_BY_FIELD_END_DATE = 'end_date';
    const CAMPAIGN_ORDER_BY_FIELD_UPDATED_AT = 'updated_at';
    const CAMPAIGN_ORDER_BY_FIELD_COUNTRY = 'country';

    const CAMPAIGN_ORDER_BY_DIRECTION_ASC = 'ASC';
    const CAMPAIGN_ORDER_BY_DIRECTION_DESC = 'DESC';

    /**
     * Choose the publisher on behalf the requests will be done.
     *
     * @param int    $publisherId Publisher ID
     * @param string $key         The key of publisher
     * @param string $secret      The secret of publisher
     *
     * @return PublisherClientInterface
     */
    public function setPublisher($publisherId, $key, $secret);

    /**
     * Return one campaign
     *
     * @param $campaignId
     *
     * @return Campaign
     */
    public function getCampaign($campaignId);

    /**
     * Returns all accessible campaigns for the current publisher.
     *
     * @param EBDateTime|null $endDateGreaterThan
     * @param int|null        $country
     * @param int|null        $parentCategory
     * @param string|null     $campaignNamePattern
     *
     * @return CampaignsCount|false
     */
    public function getCampaignsCount(
        EBDateTime $endDateGreaterThan = null,
        $country = null,
        $parentCategory = null,
        $campaignNamePattern = null
    );

    /**
     * Returns all accessible campaigns for the current publisher.
     *
     * @param string          $orderField
     * @param string          $orderDirection
     * @param EBDateTime|null $endDateGreaterThan
     * @param int|null        $country
     * @param int|null        $parentCategory
     * @param string|null     $campaignNamePattern
     * @param int|null        $page
     * @param int|null        $pageResultsNumber
     *
     * @return Campaigns|Campaign[]|false
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
    );

    /**
     * Get approval of a campaign for a list
     *
     * @param int       $campaignId
     * @param string    $listId
     *
     * @return Approval
     */
    public function getCampaignListApproval($campaignId, $listId);

    /**
     * Get lists
     *
     * @return PublisherLists
     */
    public function getLists();

    /**
     * Get list
     *
     * @param string $id
     *
     * @return PublisherList
     */
    public function getListById($id);

    /**
     * Set list definition
     *
     * @param string $id
     * @param string $name
     * @param string $description
     * @param string $fromName
     * @param string $publicName
     * @param int    $listTemplateId
     * @param int    $approvalRulesId
     * @param array  $approvalCategories
     * @param array  $minPayoutParentCategories
     * @param array  $minPayoutChildCategories
     * @param bool   $isEnabledForCPMBidding
     *
     * @return PublisherList
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
    );

    /**
     * Returns publisher lists.
     *
     * @return ListsApprovalExceptions
     */
    public function getListsApprovalExceptions();

    /**
     * Return a list of a publisher by its external id
     *
     * @param string $id
     *
     * @return ListApprovalExceptions
     */
    public function getListApprovalExceptionsById($id);

    /**
     * Update list by a publisher
     *
     * @param string    $id
     * @param array     $approved
     * @param array     $rejected
     *
     * @return ListApprovalExceptions
     */
    public function updateListApprovalExceptions($id, array $approved, array $rejected);

    /**
     * Return creativity for one campaign
     *
     * @param int $campaignId
     *
     * @return Creativities
     */
    public function getCampaignCreativities($campaignId);

    /**
     * Get publisher lists stats (totals)
     *
     * @return PublisherListsStats
     */
    public function getListStats();
}
