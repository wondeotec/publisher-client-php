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
use EBC\PublisherClient\Campaign\ListsApproval;
use EBC\PublisherClient\Campaign\ListApproval;

/**
 * ListsApprovalTest
 */
class ListsApprovalTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\ListsApproval';

    public function testDeserialize()
    {
        $listsApprovalArr = array(
            array(
                'list_external_id' => 9,
                'approval' => array(
                    'approved' => true,
                    'type' => 'manual'
                )
            ),
            array(
                'list_external_id' => 7,
                'approval' => array(
                    'approved' => false,
                    'type' => 'auto'
                )
            )
        );

        /** @var ListsApproval $listsApproval */
        $listsApproval = $this->deserialize(
            array('items' => $listsApprovalArr),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $listsApproval);
        $this->assertCount(2, $listsApproval);

        $pos = 0;
        /** @var ListApproval $listApproval */
        foreach ($listsApproval as $listApproval) {
            $this->assertEquals($listsApprovalArr[$pos]['list_external_id'], $listApproval->getListExternalId());
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
            $this->assertEquals(
                $listsApprovalArr[$pos]['approval']['approved'],
                $listApproval->getApproval()->isApproved()
            );
            $this->assertEquals(
                $listsApprovalArr[$pos]['approval']['type'],
                $listApproval->getApproval()->getType()
            );
            ++$pos;
        }
    }
}
