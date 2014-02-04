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

use PHPUnit_Framework_TestCase;
use EBC\PublisherClient\PublisherClient;
use JMS\Serializer\SerializerBuilder;

/**
 * PublisherClientTest
 */
class PublisherClientTest extends TestCase
{
    public function testFirst()
    {
//        print_r((new PublisherClient())->publisher(3, 'thekey', 'thesecret')->getCampaigns());

        $serializer = SerializerBuilder::create()->addMetadataDir(
            '/var/www/publisher-client-php/src/EBC/PublisherClient/Resources/config/serializer/',
            'EBC\PublisherClient'
        )->build();

        $res = $serializer->deserialize(json_encode(array('id' => 20, 'name' => 'test')), 'EBC\PublisherClient\Campaign\Category', 'json');
        var_dump($res);

//        $res = $serializer->deserialize(json_encode(array('type' => 'cpc', 'value' => 15.9)), 'EBC\PublisherClient\Campaign\Bid', 'json');
//        var_dump($res);
//
//        $res = $serializer->deserialize(
//            json_encode(array('start_date' => '2013-01-01 00:00:00', 'end_date' => '2015-12-12 23:59:59')),
//            'EBC\PublisherClient\Campaign\Schedule', 'json'
//        );
//        var_dump($res);
//
//        $res = $serializer->deserialize(
//            json_encode(
//                array(
//                    'id' => 20,
//                    'name' => 'test',
//                    'schedule' => array(
//                        'start_date' => '2013-01-01 00:00:00',
//                        'end_date' => '2015-12-12 23:59:59'
//                    ),
//                    'bid' => array(
//                        'type' => 'cpc',
//                        'value' => 15.9
//                    )
//                )
//            ),
//            'EBC\PublisherClient\Campaign\Campaign', 'json'
//        );
//        var_dump($res);
    }

}
