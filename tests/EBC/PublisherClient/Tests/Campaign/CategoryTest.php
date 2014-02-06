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
use EBC\PublisherClient\Campaign\Category;

/**
 * CategoryTest
 */
class CategoryTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Category';

    public function testDeserialize()
    {
        /** @var Category $category */
        $category = $this->deserialize(array('name' => 'test'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $category);
        $this->assertEquals('test', $category->getName());
    }
}
