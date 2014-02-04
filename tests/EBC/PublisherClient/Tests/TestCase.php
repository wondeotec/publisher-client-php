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
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Handler\HandlerRegistry;
use EBT\EBDate\Serializer\EBDateTimeHandler;

/**
 * TestCase
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        return SerializerBuilder::create()
            ->addMetadataDir(
                __DIR__ . '/../../../../src/EBC/PublisherClient/Resources/config/serializer/',
                'EBC\PublisherClient'
            )->configureHandlers(
                function (HandlerRegistry $registry) {
                    $registry->registerSubscribingHandler(new EBDateTimeHandler());
                }
            )->build();
    }

    /**
     * @param array  $data
     * @param string $class
     *
     * @return object
     */
    protected function deserialize(array $data, $class)
    {
        return $this->getSerializer()->deserialize(json_encode($data), $class, 'json');
    }
}
