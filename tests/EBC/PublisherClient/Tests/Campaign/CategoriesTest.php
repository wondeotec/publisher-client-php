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
use EBC\PublisherClient\Campaign\Categories;
use EBC\PublisherClient\Campaign\Category;

/**
 * CategoriesTest
 */
class CategoriesTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Categories';

    public function testDeserialize()
    {
        $categoriesArr = array(
            array('id' => 20, 'name' => 'test1'),
            array('id' => 30, 'name' => 'test2')
        );

        /** @var Categories $categories */
        $categories = $this->deserialize(
            array(
                'items' => $categoriesArr
            ),
            self::CLASS_NAME
        );

        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Categories', $categories);
        $this->assertCount(2, $categories);

        $pos = 0;
        /** @var Category $category */
        foreach ($categories as $category) {
            $this->assertEquals($categoriesArr[$pos]['id'], $category->getId());
            $this->assertEquals($categoriesArr[$pos]['name'], $category->getName());
            ++$pos;
        }
    }
}
