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
use EBC\PublisherClient\Campaign\Campaigns;

/**
 * CampaignsTest
 */
class CampaignsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Campaigns';

    public function testDeserialize()
    {
        $campaignsArr = $this->getCampaignsArr();

        /** @var Campaigns $campaigns */
        $campaigns = $this->deserialize(
            $campaignsArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $campaigns);
        $this->assertCount(2, $campaigns);
    }

    /**
     * @return array
     */
    protected function getCampaignsArr()
    {
        return array(
            'items' => array(
                array(
                    'id' => 2,
                    'name' => 'just a test2',
                    'schedule' => array('start_date' => '2014-01-09 19:20:30', 'end_date' => '2014-01-28 09:18:05'),
                    'bid' => array('type' => 'cpc', 'value' => 20.9),
                    'list_approvals' => array(
                        'items' => array(
                            array(
                                'list_id' => 8,
                                'approval' => array('approved' => true, 'type' => 'auto')
                            ),
                            array(
                                'list_id' => 10,
                                'approval' => array('approved' => false, 'type' => 'manual')
                            )
                        )
                    ),
                    'categories' => array(
                        'items' => array(
                            array('id' => 1, 'name' => 'category1'),
                            array('id' => 2, 'name' => 'category2'),
                            array('id' => 3, 'name' => 'category3')
                        )
                    )
                ),
                array(
                    'id' => 3,
                    'name' => 'just a test3',
                    'schedule' => array('start_date' => '2014-01-09 19:20:30', 'end_date' => '2014-01-28 09:18:05'),
                    'bid' => array('type' => 'cpc', 'value' => 20.9),
                    'list_approvals' => array(
                        'items' => array(
                            array(
                                'list_id' => 8,
                                'approval' => array('approved' => true, 'type' => 'auto')
                            ),
                            array(
                                'list_id' => 10,
                                'approval' => array('approved' => false, 'type' => 'manual')
                            )
                        )
                    ),
                    'categories' => array(
                        'items' => array(
                            array('id' => 1, 'name' => 'category1'),
                            array('id' => 2, 'name' => 'category2'),
                            array('id' => 3, 'name' => 'category3')
                        )
                    )
                )
            )
        );
    }
}
