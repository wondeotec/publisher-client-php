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
use EBC\PublisherClient\ListApprovalExceptions\ListsApprovalExceptions;

/**
 * ListsApprovalExceptionsTest
 */
class ListsApprovalExceptionsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListApprovalExceptions\ListsApprovalExceptions';

    public function testDeserialize()
    {
        $listsArr = array(
            'items' => array(
                array(
                    'id' => 'ext1',
                    'name'        => 'list1'
                ),
                array(
                    'id' => 'ext2',
                    'name'        => 'list2'
                )
            )
        );

        /** @var ListsApprovalExceptions $lists */
        $lists = $this->deserialize(
            $listsArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $lists);
        $this->assertCount(2, $lists);
    }
}
