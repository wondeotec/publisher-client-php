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
        $this->assertEquals('application/json', $acceptHeader->getIterator()->current());

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
        $this->assertEquals('application/json', $acceptHeader->getIterator()->current());

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

    public function testGetListByExternalId()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->getListByExternalId('ext_list_id');

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
     * @group get
     */
    /*public function testGetListByExternalIdReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $list = $client->getListByExternalId('extIdList_1_publisher_1');
        var_dump($list);
    }*/

    /**
     * @expectedException \RuntimeException
     */
    public function testUpdateListByPublisherWrongStatusCode()
    {
        $client = new PublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);
        $client->updateListByPublisher('ext_list_id', 'list_name', array(1), array(2));
    }

    public function testUpdateListByPublisher()
    {
        $client = new PublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(202));
        $client->addSubscriber($plugin);
        $list = $client->updateListByPublisher('ext_list_id', 'list_name', array(1), array(2));
        $this->assertInstanceOf('EBC\PublisherClient\ListDefinition\ListDefinition', $list);
    }

    // code for testing integration
    /**
     * @group update
     */
    /*public function testUpdateListByPublisherReal()
    {
        $client = new PublisherClient();
        $client->setPublisher(1, 'key', 'secret');
        $list = $client->updateListByPublisher('extIdList_1_publisher_1', 'list_name', array(1), array(2));
        $this->assertInstanceOf('EBC\PublisherClient\ListDefinition\ListDefinition', $list);
        var_dump($list);
    }*/

    /**
     * @param array     $campaignArr
     * @param Campaign  $campaign
     */
    protected function compareCampaign($campaignArr, $campaign)
    {
        // top level stuff
        $this->assertEquals($campaignArr['id'], $campaign->getId());
        $this->assertEquals($campaignArr['name'], $campaign->getName());

        // advertiser
        $this->assertInstanceOf('EBC\PublisherClient\Advertiser\Advertiser', $campaign->getAdvertiser());
        $this->assertEquals($campaignArr['advertiser']['name'], $campaign->getAdvertiser()->getName());

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

        // total payout
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Payout', $campaign->getTotalPayout());
        $this->assertEquals($campaignArr['total_payout']['type'], $campaign->getTotalPayout()->getType());
        $this->assertEquals($campaignArr['total_payout']['value'], $campaign->getTotalPayout()->getValue());

        // publisher payout
        $this->assertInstanceOf('EBC\PublisherClient\Campaign\Payout', $campaign->getPublisherPayout());
        $this->assertEquals($campaignArr['publisher_payout']['type'], $campaign->getPublisherPayout()->getType());
        $this->assertEquals($campaignArr['publisher_payout']['value'], $campaign->getPublisherPayout()->getValue());

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
