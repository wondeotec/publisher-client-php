<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\ListDefinition;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\ListDefinition\ListDefinition;

/**
 * ListDefinitionTest
 */
class ListDefinitionTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListDefinition\ListDefinition';

    public function testDeserialize()
    {
        /** @var ListDefinition $listDefinition */
        $listDefinition = $this->deserialize(array('external_id' => 'ccc12', 'name' => 'list'), self::CLASS_NAME);

        $this->assertInstanceOf(self::CLASS_NAME, $listDefinition);
        $this->assertEquals('ccc12', $listDefinition->getExternalId());
        $this->assertEquals('list', $listDefinition->getName());
    }
} 
