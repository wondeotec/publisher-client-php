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
use EBC\PublisherClient\PublisherList\Interests;
use EBC\PublisherClient\PublisherList\Interest;

/**
 * InterestsTest
 */
class InterestsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\Interests';

    public function testDeserialize()
    {
        $interestsArr = array(
            array('id' => 20, 'name' => 'test1'),
            array('id' => 30, 'name' => 'test2')
        );

        /** @var Interests $categories */
        $interests = $this->deserialize(
            array('items' => $interestsArr),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $interests);
        $this->assertCount(2, $interests);

        $pos = 0;
        /** @var Interest $interest */
        foreach ($interests as $interest) {
            $this->assertEquals($interestsArr[$pos]['id'], $interest->getId());
            $this->assertEquals($interestsArr[$pos]['name'], $interest->getName());
            ++$pos;
        }
    }
}
