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
     * Return creativity for one campaign
     *
     * @param int $campaignId
     *
     * @return Creativities
     */
    public function getCampaignCreativities($campaignId);

    /**
     * Returns all accessible campaigns for the current publisher.
     *
     * @param string|null       $orderBy            created|updated|null
     * @param string|null       $order              asc|desc|ASC|DESC|null
     * @param EBDateTime|null   $endDateGreaterThan
     * @param int|null          $country
     * @param int|null          $category
     * @param int|null          $limit
     *
     * @return Campaigns|Campaign[]
     */
    public function getCampaigns(
        $orderBy = null,
        $order = null,
        EBDateTime $endDateGreaterThan = null,
        $country = null,
        $category = null,
        $limit = null
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
     * @param string    $id
     * @param string    $newId
     * @param string    $name
     * @param string    $description
     * @param string    $fromName
     * @param string    $publicName
     * @param int       $listTemplateId
     * @param int       $approvalRulesId
     * @param array     $approvalCategories
     * @param array     $minPayoutParentCategories
     * @param array     $minPayoutChildCategories
     *
     * @return PublisherList
     */
    public function updateList(
        $id,
        $newId,
        $name,
        $description,
        $fromName,
        $publicName,
        $listTemplateId,
        $approvalRulesId,
        array $approvalCategories,
        array $minPayoutParentCategories,
        array $minPayoutChildCategories
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
     * Get publisher lists stats (totals)
     *
     * @return PublisherListsStats
     */
    public function getListStats();
}
