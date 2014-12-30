<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\PublisherList\PublisherListStats;
use EBC\PublisherClient\Tests\TestCase;

class PublisherListStatsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\PublisherListStats';

    public function testDeserialize()
    {
        /** @var PublisherListStats $list */
        $list = $this->deserialize(
            array(
                'id' => 'ccc12',
                'total_subscribers' => 100,
                'total_unsubscribes' => 2,
                'total_bounces' => 5,
            ),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $list);
        $this->assertEquals('ccc12', $list->getId());
        $this->assertEquals(100, $list->getTotalSubscribers());
        $this->assertEquals(2, $list->getTotalUnsubscribes());
        $this->assertEquals(5, $list->getTotalBounces());
    }
}
