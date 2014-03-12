<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\ListDefinition;

/**
 * ApprovalCampaignsExceptions
 */
class ApprovalCampaignsExceptions
{
    /**
     * @var array
     */
    protected $approved;

    /**
     * @var array
     */
    protected $rejected;

    /**
     * @return array
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @return array
     */
    public function getRejected()
    {
        return $this->rejected;
    }
}
