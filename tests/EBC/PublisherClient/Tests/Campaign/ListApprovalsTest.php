<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient\Tests\Campaign;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\Campaign\ListApprovals;
use EBC\PublisherClient\Campaign\ListApproval;

/**
 * ListApprovalsTest
 */
class ListApprovalsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\ListApprovals';

    public function testDeserialize()
    {
        $listApprovalsArr = array(
            array(
                'list_id' => 9,
                'approval' => array(
                    'approved' => true,
                    'type' => 'manual'
                )
            ),
            array(
                'list_id' => 7,
                'approval' => array(
                    'approved' => false,
                    'type' => 'auto'
                )
            )
        );

        /** @var ListApprovals $listApprovals */
        $listApprovals = $this->deserialize(
            array('items' => $listApprovalsArr),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $listApprovals);
        $this->assertCount(2, $listApprovals);

        $pos = 0;
        /** @var ListApproval $listApproval */
        foreach ($listApprovals as $listApproval) {
            $this->assertEquals($listApprovalsArr[$pos]['list_id'], $listApproval->getListId());
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
            $this->assertEquals(
                $listApprovalsArr[$pos]['approval']['approved'],
                $listApproval->getApproval()->isApproved()
            );
            $this->assertEquals(
                $listApprovalsArr[$pos]['approval']['type'],
                $listApproval->getApproval()->getType()
            );
            ++$pos;
        }
    }
}
