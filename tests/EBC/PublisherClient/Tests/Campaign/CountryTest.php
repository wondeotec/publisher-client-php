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
use EBC\PublisherClient\Campaign\Country;

/**
 * CountryTest
 */
class CountryTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Country';

    public function testDeserialize()
    {
        /** @var Country $country */
        $country = $this->deserialize(array('code' => 'PT', 'name' => 'Portugal'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $country);
        $this->assertEquals('PT', $country->getCode());
        $this->assertEquals('Portugal', $country->getName());
    }
} 
