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

use EBC\PublisherClient\Campaign\CampaignFilter;
use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\Campaign\Categories;
use EBC\PublisherClient\Campaign\Category;

/**
 * CategoriesTest
 */
class CampaignFilterTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\CampaignFilter';

    public function testDeserialize()
    {
        $json = '[{"values_long":["25-34","35-44","45-54","> 55","Unknown"],"values_short":["C","D","E","F","NA"],"display_name":"age","name":"age_id"},
                  {"values_long":["Female"],"values_short":["F"],"display_name":"gender","name":"gender_id"}]';
        $obj  = json_decode($json);

        /** @var CampaignFilter[] $filters */
        $filters = $this->deserialize(
            $obj,
            'array<'.self::CLASS_NAME.">" //deserialize an array of CLASS_NAME
        );

        $this->assertCount(2, $filters);
        $this->assertInstanceOf(self::CLASS_NAME, $filters[0]);

        $this->assertEquals("age", $filters[0]->getDisplayName());
        $this->assertEquals("25-34", $filters[0]->getValuesLong()[0]);
        $this->assertEquals("Female", $filters[1]->getValuesLong()[0]);
    }
}
