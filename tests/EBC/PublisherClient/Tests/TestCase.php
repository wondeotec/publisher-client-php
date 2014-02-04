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
use JMS\Serializer\SerializerBuilder;

/**
 * TestCase
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public function getSerializer()
    {
        SerializerBuilder::create()->addMetadataDir(
            '/var/www/publisher-client-php/src/EBC/PublisherClient/Resources/config/serializer/',
            'EBC\PublisherClient'
        )->build();
    }
}
