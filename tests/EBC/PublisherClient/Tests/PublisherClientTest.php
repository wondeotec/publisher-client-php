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
        $client = new PublisherClient();
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
        $client = new PublisherClient();
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
        $client = new PublisherClient();
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(500));
        $client->addSubscriber($plugin);
        $client->getCampaigns();
    }

    public function testGetCampaigns()
    {
        $client = new PublisherClient();
        $client->setPublisher(2, 'thekey', 'thesecret');
        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200, null, file_get_contents(__DIR__ . '/Model/campaigns.json')));
        $client->addSubscriber($plugin);

        $campaigns = $client->getCampaigns();
        $this->assertCount(7, $campaigns);

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
}
