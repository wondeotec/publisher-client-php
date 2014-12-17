<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\ListApprovalExceptions\ListApprovalExceptions;

/**
 * ListApprovalExceptionsTest
 */
class ListApprovalExceptionsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListApprovalExceptions\ListApprovalExceptions';

    public function testDeserialize()
    {
        /** @var ListApprovalExceptions $listApprovalExceptions */
        $listApprovalExceptions = $this->deserialize(
            array('id' => 'ccc12', 'name' => 'list'),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $listApprovalExceptions);
        $this->assertEquals('ccc12', $listApprovalExceptions->getId());
        $this->assertEquals('list', $listApprovalExceptions->getName());
    }
}
