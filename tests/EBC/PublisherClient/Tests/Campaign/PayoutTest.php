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
use EBC\PublisherClient\Campaign\Payout;

/**
 * PayoutTest
 */
class PayoutTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Payout';

    public function testDeserialize()
    {
        /** @var Payout $payout */
        $payout = $this->deserialize(array('type' => 'cpc', 'value' => 20.9), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $payout);
        $this->assertEquals('cpc', $payout->getType());
        $this->assertEquals(20.9, $payout->getValue());
    }
}
