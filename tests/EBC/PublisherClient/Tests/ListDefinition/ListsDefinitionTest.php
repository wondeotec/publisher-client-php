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
use EBC\PublisherClient\ListDefinition\ListsDefinition;

/**
 * ListsDefinitionTest
 */
class ListsDefinitionTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListDefinition\ListsDefinition';

    public function testDeserialize()
    {
        $listsArr = array(
            'items' => array(
                array(
                    'external_id' => 'ext1',
                    'name'        => 'list1'
                ),
                array(
                    'external_id' => 'ext2',
                    'name'        => 'list2'
                )
            )
        );

        /** @var ListsDefinition $listsDefinition */
        $lists = $this->deserialize(
            $listsArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $lists);
        $this->assertCount(2, $lists);
    }
}
