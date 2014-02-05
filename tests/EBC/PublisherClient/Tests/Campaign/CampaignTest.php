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

        // bid
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Bid', $campaign->getBid());
        $this->assertEquals('cpc', $campaign->getBid()->getType());
        $this->assertEquals(20.9, $campaign->getBid()->getValue());

        // list approvals
        $listsApproval = $campaign->getListsApproval();
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\ListsApproval', $listsApproval);
        $this->assertCount(2, $listsApproval);
        $pos = 0;
        foreach ($listsApproval as $listApproval) {
            $listsApprovalArr = $campaignArr['lists_approval']['items'][$pos];
            $this->assertEquals($listsApprovalArr['list_id'], $listApproval->getListId());
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
            $this->assertEquals($listsApprovalArr['approval']['approved'], $listApproval->getApproval()->isApproved());
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
            $this->assertEquals($categoryArr['id'], $category->getId());
            $this->assertEquals($categoryArr['name'], $category->getName());
            ++$pos;
        }

    }

    /**
     * @return array
     */
    protected function getCampaignArr()
    {
        return array(
            'id' => 2,
            'name' => 'just a test',
            'schedule' => array(
                'start_date' => '2014-01-09 19:20:30',
                'end_date' => '2014-01-28 09:18:05'
            ),
            'bid' => array(
                'type' => 'cpc',
                'value' => 20.9
            ),
            'lists_approval' => array(
                'items' => array(
                    array(
                        'list_id' => 8,
                        'approval' => array(
                            'approved' => true,
                            'type' => 'auto'
                        )
                    ),
                    array(
                        'list_id' => 10,
                        'approval' => array(
                            'approved' => false,
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
            )
        );
    }
}
