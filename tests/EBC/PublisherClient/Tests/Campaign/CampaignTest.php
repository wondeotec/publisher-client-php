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
use EBC\PublisherClient\Campaign\Campaign;

/**
 * CampaignTest
 */
class CampaignTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Campaign';

    public function testDeserialize()
    {
        $campaignArr = $this->getCampaignArr();

        /** @var Campaign $campaign */
        $campaign = $this->deserialize(
            $campaignArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $campaign);

        // top level stuff
        $this->assertEquals(2, $campaign->getId());
        $this->assertEquals('just a test', $campaign->getName());
        $this->assertEquals('bla bla', $campaign->getDescription());

        // advertiser
        $this->assertInstanceOf('EBC\PublisherClient\Advertiser\Advertiser', $campaign->getAdvertiser());
        $this->assertEquals('advertiser 1', $campaign->getAdvertiser()->getName());

        // schedule
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Schedule', $campaign->getSchedule());
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getSchedule()->getStartDate());
        $this->assertEquals(
            '2014-01-09 19:20:30',
            $campaign->getSchedule()->getStartDate()->formatAsString()
        );
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getSchedule()->getEndDate());
        $this->assertEquals(
            '2014-01-28 09:18:05',
            $campaign->getSchedule()->getEndDate()->formatAsString()
        );

        // country
        $this->assertInstanceOf('EBC\PublisherClient\Locale\Country', $campaign->getCountry());
        $this->assertEquals('PT', $campaign->getCountry()->getCode());
        $this->assertEquals('Portugal', $campaign->getCountry()->getName());

        // total payout
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Payout', $campaign->getTotalPayout());
        $this->assertEquals('cpc', $campaign->getTotalPayout()->getType());
        $this->assertEquals(0.9, $campaign->getTotalPayout()->getValue());

        // publisher payout
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Payout', $campaign->getPublisherPayout());
        $this->assertEquals('cpc', $campaign->getPublisherPayout()->getType());
        $this->assertEquals(0.7, $campaign->getPublisherPayout()->getValue());

        // list approvals
        $listsApproval = $campaign->getListsApproval();
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\ListsApproval', $listsApproval);
        $this->assertCount(2, $listsApproval);
        $pos = 0;
        foreach ($listsApproval as $listApproval) {
            $listsApprovalArr = $campaignArr['lists_approval']['items'][$pos];
            $this->assertEquals($listsApprovalArr['list_external_id'], $listApproval->getListExternalId());
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
            $this->assertEquals($listsApprovalArr['approval']['status'], $listApproval->getApproval()->getStatus());
            $this->assertEquals($listsApprovalArr['approval']['type'], $listApproval->getApproval()->getType());
            ++$pos;
        }

        // categories
        $categories = $campaign->getCategories();
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Categories', $categories);
        $this->assertCount(3, $categories);
        $pos = 0;
        foreach ($categories as $category) {
            $categoryArr = $campaignArr['categories']['items'][$pos];
            $this->assertEquals($categoryArr['name'], $category->getName());
            ++$pos;
        }

        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getUpdatedAt());
        $this->assertEquals(
            '2014-01-09 19:20:30',
            $campaign->getUpdatedAt()->formatAsString()
        );
    }

    /**
     * @return array
     */
    protected function getCampaignArr()
    {
        return array(
            'id' => 2,
            'name' => 'just a test',
            'description' => 'bla bla',
            'advertiser' => array(
                'name' => 'advertiser 1'
            ),
            'schedule' => array(
                'start_date' => '2014-01-09 19:20:30',
                'end_date' => '2014-01-28 09:18:05'
            ),
            'total_payout' => array(
                'type' => 'cpc',
                'value' => 0.9
            ),
            'publisher_payout' => array(
                'type' => 'cpc',
                'value' => 0.7
            ),
            'country' => array(
                'code' => 'PT',
                'name' => 'Portugal'
            ),
            'lists_approval' => array(
                'items' => array(
                    array(
                        'list_external_id' => 8,
                        'approval' => array(
                            'status' => 'low_bid',
                            'type' => 'auto'
                        )
                    ),
                    array(
                        'list_external_id' => 10,
                        'approval' => array(
                            'status' => 'rejected',
                            'type' => 'manual'
                        )
                    )
                )
            ),
            'categories' => array(
                'items' => array(
                    array(
                        'id' => 1,
                        'name' => 'category1'
                    ),
                    array(
                        'id' => 2,
                        'name' => 'category2'
                    ),
                    array(
                        'id' => 3,
                        'name' => 'category3'
                    )
                )
            ),
            'updated_at' => '2014-01-09 19:20:30'
        );
    }
}
