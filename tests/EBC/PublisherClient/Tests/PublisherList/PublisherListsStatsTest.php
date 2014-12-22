<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rochao@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\PublisherList\PublisherListsStats;
use EBC\PublisherClient\Tests\TestCase;

class PublisherListsStatsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\PublisherListsStats';

    public function testDeserialize()
    {
        $listsArr = array(
            'items' => array(
                array(
                    'id' => 'ccc12',
                    'total_subscribers' => 100,
                    'total_unsubscribes' => 2,
                    'total_bounces' => 5,
                ),
                array(
                    'id' => 1,
                    'total_subscribers' => 200,
                    'total_unsubscribes' => 4,
                    'total_bounces' => 50,
                ),
            )
        );

        /** @var PublisherListsStats $listsStats */
        $lists = $this->deserialize(
            $listsArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $lists);
        $this->assertCount(2, $lists);
    }
}
