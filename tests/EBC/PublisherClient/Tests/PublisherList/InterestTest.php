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
use EBC\PublisherClient\PublisherList\Interest;

/**
 * InterestTest
 */
class InterestTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\Interest';

    public function testDeserialize()
    {
        /** @var Interest $interest */
        $category = $this->deserialize(array('id' => 1, 'name' => 'test'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $category);
        $this->assertEquals('test', $category->getName());
    }
}
