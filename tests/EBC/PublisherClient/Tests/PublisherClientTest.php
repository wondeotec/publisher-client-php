<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient\Tests;

use EBC\PublisherClient\Campaign\Campaign;
use EBC\PublisherClient\PublisherClient;
use EBC\PublisherClient\PublisherClientInterface;
use EBT\EBDate\EBDateTime;
use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\Header;

/**
 * PublisherClientTest
 */
class PublisherClientTest extends TestCase
{
    /**
     * @expectedException \JMS\Serializer\Exception\RuntimeException
     */
    public function testMalformedJson()
    {
        $client = $this->getPublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200, null, 'malformed JSON'));
        $client->addSubscriber($plugin);
        $client->getCampaigns();
    }

    /**
     * @expectedException \Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testClientErrorTransformedClientException()
    {
        $client = $this->getPublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(400));
        $client->addSubscriber($plugin);
        $client->getCampaigns();
    }

    /**
     * @expectedException \Guzzle\Http\Exception\ServerErrorResponseException
     */
    public function testServerErrorTransformedServerException()
    {
        $client = $this->getPublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(500));
        $client->addSubscriber($plugin);
        $client->getCampaigns();
    }

    public function testGetCampaignById()
    {
        $client = $this->getPublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $campaignJson = file_get_contents(__DIR__ . '/Model/campaign.json');

        $plugin->addResponse(new Response(200, null, $campaignJson));
        $client->addSubscriber($plugin);
        $campaign = $client->getCampaign(1);

        $campaignArr = json_decode($campaignJson, true);

        $this->compareCampaign($campaignArr, $campaign);

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];
        $this->assertEquals('GET', $request->getMethod());
        /** @var Header $acceptHeader */
        $acceptHeader = $request->getHeader('Accept');
        $this->assertCount(1, $acceptHeader);
        $this->assertEquals(
            'application/vnd.emailbidding+json; version=1.2.2',
            $acceptHeader->getIterator()->current()
        );

        $this->assertEquals(
            'https://api.emailbidding.com/api/p/publishers/2/campaigns/1?key=thekey&secret=thesecret',
            $request->getUrl()
        );
    }

    public function testGetCampaignCreativities()
    {
        $client = $this->getPublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $campaignsJson = file_get_contents(__DIR__ . '/Model/creativities.json');

        $plugin->addResponse(new Response(200, null, $campaignsJson));
        $client->addSubscriber($plugin);

        $campaignsArr = json_decode($campaignsJson, true)['items'];

        $campaigns = $client->getCampaignCreativities(1);

        $this->assertCount(1, $campaigns);
        $pos = 0;

        foreach ($campaigns as $campaign) {
            $campaignArr =  $campaignsArr[$pos];

            // fromName
            $this->assertEquals($campaignArr['from_name'], $campaign->getFromName());
            // subject
            $this->assertEquals($campaignArr['subject'], $campaign->getSubject());
            // bodyHtml
            $this->assertEquals($campaignArr['body_html'], $campaign->getBodyHtml());

            ++$pos;
        }

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];
        $this->assertEquals('GET', $request->getMethod());
        /** @var Header $acceptHeader */
        $acceptHeader = $request->getHeader('Accept');
        $this->assertCount(1, $acceptHeader);
        $this->assertEquals('application/json', $acceptHeader->getIterator()->current());

        $this->assertEquals(
            'https://api.emailbidding.com/api/p/publishers/2/campaigns/1/creativities?key=thekey&secret=thesecret',
            $request->getUrl()
        );
    }

    public function testGetCampaigns()
    {
        $client = $this->getPublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $campaignsJson = file_get_contents(__DIR__ . '/Model/campaigns.json');
        $plugin->addResponse(new Response(200, null, $campaignsJson));
        $client->addSubscriber($plugin);

        $campaignsArr = json_decode($campaignsJson, true)['items'];
        $pos = 0;

        $campaigns = $client->getCampaigns();
        $this->assertCount(7, $campaigns);

        foreach ($campaigns as $campaign) {
            $campaignArr =  $campaignsArr[$pos];

            $this->compareCampaign($campaignArr, $campaign);

            // updated at
            $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getUpdatedAt());
            $this->assertEquals($campaignArr['updated_at'], $campaign->getUpdatedAt()->formatAsString());

            ++$pos;
        }

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];
        $this->assertEquals('GET', $request->getMethod());
        /** @var Header $acceptHeader */
        $acceptHeader = $request->getHeader('Accept');
        $this->assertCount(1, $acceptHeader);
        $this->assertEquals(
            'application/vnd.emailbidding+json; version=1.2.2',
            $acceptHeader->getIterator()->current()
        );

        $this->assertEquals(
            'https://api.emailbidding.com/api/p/publishers/2/campaigns?key=thekey&secret=thesecret',
            $request->getUrl()
        );
    }

    public function testGetCampaignsOrdered()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200, null, file_get_contents(__DIR__ . '/Model/campaigns.json')));
        $client->addSubscriber($plugin);

        $date = EBDateTime::createFromFormat(EBDateTime::getDateFormat(), '2014-02-15');
        $campaigns = $client->getCampaigns('updated', 'desc', $date, 1, 1, 3);
        $this->assertCount(7, $campaigns);

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/campaigns?key=thekey&secret=thesecret&order_by=updated&order=desc&endDateGreaterThan=2014-02-15&country=1&category=1&limit=3',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    public function testGetCampaignListApproval()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->getCampaignListApproval(1, 'ext_list_id');

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/campaigns/1/lists/ext_list_id?key=thekey&secret=thesecret',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    public function testGetLists()
    {
        $client = $this->getPublisherClient();
        $client->setPublisher(1, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $listsJson = file_get_contents(__DIR__ . '/Model/lists.json');
        $plugin->addResponse(new Response(200, null, $listsJson));
        $client->addSubscriber($plugin);

        $lists = $client->getLists();
        $this->assertInstanceOf('EBC\PublisherClient\PublisherList\PublisherLists', $lists);
        $this->assertCount(5, $lists);

        foreach ($lists as $list) {
            $this->assertInstanceOf('EBC\PublisherClient\PublisherList\PublisherList', $list);
        }

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];
        $this->assertEquals('GET', $request->getMethod());

        /** @var Header $acceptHeader */
        $acceptHeader = $request->getHeader('Accept');
        $this->assertCount(1, $acceptHeader);
        $this->assertEquals('application/vnd.emailbidding+json; version=1.2.0', $acceptHeader->getIterator()->current());

        $this->assertEquals(
            'https://api.emailbidding.com/api/p/publishers/1/lists?key=thekey&secret=thesecret',
            $request->getUrl()
        );
    }

    public function testGetListById()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->getListById('ext_list_id');

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/lists/ext_list_id?key=thekey&secret=thesecret',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    // code for testing integration
    /**
     * @group get-list
     */
    /*public function testGetListByIdReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $list = $client->getListById('extIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\PublisherList\PublisherList',
            $list,
            'Not obtained list for list with external id "extIdList_1_publisher_1"'
        );
    }*/

    /**
     * @group get-list
     */
    /*public function testGetListsReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $lists = $client->getLists('extIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\PublisherList\PublisherLists',
            $lists,
            'Not obtained lists for publisher"'
        );
    }*/

    /**
     * @group update-list
     */
    /*public function testUpdateListByPublisherRealApprovalRules()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $client->updateList(
            'extIdList_1_publisher_1',
            'newExtIdList_1_publisher_1',
            'newName',
            'newDescription',
            'newFromName',
            'newPublicName',
            2,
            2,
            array(),
            array(1 => 0.1),
            array(1 => 0.1, 2 => 0.2)
        );

        $list = $client->getListById('newExtIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\PublisherList\PublisherList',
            $list,
            'Not obtained list for list with new external id "newExtIdList_1_publisher_1"'
        );

        $this->assertInstanceOf('EBC\PublisherClient\PublisherList\PublisherList', $list);
    }*/

    /**
     * @group update-list
     */
    /*public function testUpdateListByPublisherRealCustomApproval()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $client->updateList(
            'extIdList_2_publisher_1',
            'newExtIdList_2_publisher_1',
            'newName',
            'newDescription',
            'newFromName',
            'newPublicName',
            2,
            null,
            array(4, 5, 7),
            array(1 => 0.4),
            array(1 => 0.1, 4 => 0.2, 30 => 0.15)
        );

        $list = $client->getListById('newExtIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\PublisherList\PublisherList',
            $list,
            'Not obtained list for list with new external id "newExtIdList_1_publisher_1"'
        );

        $this->assertInstanceOf('EBC\PublisherClient\PublisherList\PublisherList', $list);
    }*/

    public function testGetListApprovalExceptionsById()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->getListApprovalExceptionsById('ext_list_id');

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/lists/ext_list_id/approvals?key=thekey&secret=thesecret',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUpdateListApprovalExceptionsWrongStatusCode()
    {
        $client = new PublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(202));
        $client->addSubscriber($plugin);
        $client->updateListApprovalExceptions('ext_list_id', array(1), array(2));
    }

    /**
     * @group now
     */
    public function testUpdateListApprovalExceptions()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(204));
        $client->addSubscriber($plugin);
        $client->updateListApprovalExceptions('ext_list_id', array(1), array(2));

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/lists/ext_list_id/approvals?key=thekey&secret=thesecret',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    /**
     * @group get-list-approval
     */
    /*public function testGetListApprovalExceptionsByIdReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $list = $client->getListApprovalExceptionsById('extIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\ListApprovalExceptions\ListApprovalExceptions',
            $list,
            'Not obtained list approval exceptions for list with external id "extIdList_1_publisher_1"'
        );
    }*/

    /**
     * @group get-list-approval
     */
    /*public function testGetListsApprovalExceptionsReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $lists = $client->getListsApprovalExceptions('extIdList_1_publisher_1');
        $this->assertInstanceOf(
            'EBC\PublisherClient\ListApprovalExceptions\ListsApprovalExceptions',
            $lists,
            'Not obtained lists approval exceptions for publisher"'
        );
    }*/

    // code for testing integration
    /**
     * @group update-list-approval
     */
    /*public function testUpdateListApprovalExceptionsByPublisherReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $client->updateListApprovalExceptions('extIdList_1_publisher_1', array(1), array(2));
        $list = $client->getListApprovalExceptionsById('extIdList_1_publisher_1');
        $this->assertInstanceOf('EBC\PublisherClient\ListApprovalExceptions\ListApprovalExceptions', $list);
    }*/

    public function testGetListStatsById()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->getListStats();

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/lists/stats?key=thekey&secret=thesecret',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    /**
     * @param array     $campaignArr
     * @param Campaign  $campaign
     */
    protected function compareCampaign($campaignArr, $campaign)
    {
        // top level stuff
        $this->assertEquals($campaignArr['id'], $campaign->getId());
        $this->assertEquals($campaignArr['name'], $campaign->getName());

        // country
        $this->assertInstanceOf('EBC\PublisherClient\Locale\Country', $campaign->getCountry());
        $this->assertEquals($campaignArr['country']['code'], $campaign->getCountry()->getCode());
        $this->assertEquals($campaignArr['country']['name'], $campaign->getCountry()->getName());

        // schedule
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Schedule', $campaign->getSchedule());
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getSchedule()->getStartDate());
        $this->assertEquals(
            $campaignArr['schedule']['start_date'],
            $campaign->getSchedule()->getStartDate()->formatAsString()
        );
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $campaign->getSchedule()->getEndDate());
        $this->assertEquals(
            $campaignArr['schedule']['end_date'],
            $campaign->getSchedule()->getEndDate()->formatAsString()
        );

        // payout
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Payout', $campaign->getPayout());
        $this->assertEquals($campaignArr['payout']['type'], $campaign->getPayout()->getType());
        $this->assertEquals($campaignArr['payout']['value'], $campaign->getPayout()->getValue());

        // categories
        $categories = $campaign->getCategories();
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Categories', $categories);
        $this->assertCount(count($campaignArr['categories']['items']), $categories);
        $posCategory = 0;
        foreach ($categories as $category) {
            $categoryArr = $campaignArr['categories']['items'][$posCategory];
            $this->assertEquals($categoryArr['name'], $category->getName());
            ++$posCategory;
        }
    }

    /**
     * @return PublisherClientInterface
     */
    protected function getPublisherClient()
    {
        return new PublisherClient();
    }
}
