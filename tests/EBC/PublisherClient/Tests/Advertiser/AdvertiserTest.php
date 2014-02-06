<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient\Tests\Advertiser;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\Advertiser\Advertiser;

/**
 * ApprovalTest
 */
class AdvertiserTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Advertiser\Advertiser';

    public function testDeserialize()
    {
        /** @var Advertiser $advertiser */
        $advertiser = $this->deserialize(array('name' => 'advertiser 1'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $advertiser);
        $this->assertEquals('advertiser 1', $advertiser->getName());
    }
}
