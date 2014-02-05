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
use EBC\PublisherClient\Campaign\Approval;

/**
 * ApprovalTest
 */
class ApprovalTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Approval';

    public function testDeserialize()
    {
        /** @var Approval $approval */
        $approval = $this->deserialize(array('approved' => false, 'type' => 'auto'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $approval);
        $this->assertEquals(false, $approval->isApproved());
        $this->assertEquals('auto', $approval->getType());
    }
}
