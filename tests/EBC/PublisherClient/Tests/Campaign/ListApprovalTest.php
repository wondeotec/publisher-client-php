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
use EBC\PublisherClient\Campaign\ListApproval;

/**
 * ListApprovalTest
 */
class ListApprovalTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\ListApproval';

    public function testDeserialize()
    {
        /** @var ListApproval $listApproval */
        $listApproval = $this->deserialize(
            array(
                'list_external_id' => 9,
                'approval' => array(
                    'status' => 'rejected',
                    'type' => 'manual'
                )
            ),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $listApproval);
        $this->assertEquals(9, $listApproval->getListExternalId());
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
        $this->assertEquals('rejected', $listApproval->getApproval()->getStatus());
        $this->assertEquals('manual', $listApproval->getApproval()->getType());
    }
}
