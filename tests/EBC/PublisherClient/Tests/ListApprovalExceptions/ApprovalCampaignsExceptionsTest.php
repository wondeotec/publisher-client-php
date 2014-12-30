<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\ListApprovalExceptions\ApprovalCampaignsExceptions;

/**
 * ApprovalCampaignsExceptionsTest
 */
class ApprovalCampaignsExceptionsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListApprovalExceptions\ApprovalCampaignsExceptions';

    public function testDeserialize()
    {
        /** @var ApprovalCampaignsExceptions $approvalCampaignsExceptions */
        $approvalCampaignsExceptions = $this->deserialize(
            array('approved' => array(1, 2, 3), 'rejected' => array(1, 2, 3)),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $approvalCampaignsExceptions);
    }
}
