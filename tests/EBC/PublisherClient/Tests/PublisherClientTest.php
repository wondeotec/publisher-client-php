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

use EBC\PublisherClient\PublisherClient;
use EBC\PublisherClient\PublisherClientInterface;
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
            // top level stuff
            $this->assertEquals($campaignArr['id'], $campaign->getId());
            $this->assertEquals($campaignArr['name'], $campaign->getName());

            // advertiser
            $this->assertInstanceOf('EBC\PublisherClient\Advertiser\Advertiser', $campaign->getAdvertiser());
            $this->assertEquals($campaignArr['advertiser']['name'], $campaign->getAdvertiser()->getName());

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

            // bid
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\Bid', $campaign->getBid());
            $this->assertEquals($campaignArr['bid']['type'], $campaign->getBid()->getType());
            $this->assertEquals($campaignArr['bid']['value'], $campaign->getBid()->getValue());

            // list approvals
            $listsApproval = $campaign->getListsApproval();
            $this->assertInstanceOf('EBC\PublisherClient\Campaign\ListsApproval', $listsApproval);
            $this->assertCount(count($campaignArr['lists_approval']['items']), $listsApproval);
            $posApproval = 0;
            foreach ($listsApproval as $listApproval) {
                $listsApprovalArr = $campaignArr['lists_approval']['items'][$posApproval];
                $this->assertEquals($listsApprovalArr['list_external_id'], $listApproval->getListExternalId());
                $this->assertInstanceOf('EBC\PublisherClient\Campaign\Approval', $listApproval->getApproval());
                $this->assertEquals(
                    $listsApprovalArr['approval']['approved'],
                    $listApproval->getApproval()->isApproved()
                );
                $this->assertEquals($listsApprovalArr['approval']['type'], $listApproval->getApproval()->getType());
                ++$posApproval;
            }

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

        $campaigns = $client->getCampaigns('updated', 'desc');
        $this->assertCount(7, $campaigns);

        /** @var Request $request */
        $request = $plugin->getReceivedRequests()[0];

        $this->assertEquals(
            // @codingStandardsIgnoreStart
            'https://api.emailbidding.com/api/p/publishers/2/campaigns?key=thekey&secret=thesecret&order_by=updated&order=desc',
            // @codingStandardsIgnoreEnd
            $request->getUrl()
        );
    }

    /**
     * @return PublisherClientInterface
     */
    protected function getPublisherClient()
    {
        return new PublisherClient();
    }
}
