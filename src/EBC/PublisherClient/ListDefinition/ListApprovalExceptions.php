<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\ListDefinition;

/**
 * ListApprovalExceptions
 */
class ListApprovalExceptions
{
    /**
     * @var string
     */
    protected $externalId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ApprovalCampaignsExceptions
     */
    protected $approvalCampaignsExceptions;

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ApprovalCampaignsExceptions
     */
    public function getApprovalCampaignsExceptions()
    {
        return $this->approvalCampaignsExceptions;
    }
}
