<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rochao@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\PublisherList\PublisherLists;
use EBC\PublisherClient\Tests\TestCase;

class PublisherListsTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\PublisherLists';

    public function testDeserialize()
    {
        $listsArr = array(
            'items' => array(
                array(
                    'id' => 'ccc12',
                    'name' => 'list',
                    'description' => 'list description',
                    'interests' => array('1', '2'),
                    'from_name' => 'fromName',
                    'from_email' => 'fromEmail',
                    'public_name' => 'publicName',
                    'custom_domain' => 'customDomain',
                    'head_domain' => 'headDomain',
                    'tracking_domain' => 'trackingDomain',
                    'reply_to_email' => 'replyToEmail',
                    'default_country_name' => 'defaultCountryName',
                    'list_template_id' => 1,
                    'approval_rules_id' => 2,
                    'approved_categories' => array('1', '2'),
                    'min_payout_parent_categories' => array('1' => '0.10', '2' => '0.10'),
                    'min_payout_child_categories' => array('1' => '0.10', '2' => '0.10'),
                    'is_enabled_for_c_p_m_bidding' => true,
                ),
                array(
                    'id' => 'ccc12',
                    'name' => 'list',
                    'description' => 'list description',
                    'interests' => array('1', '2'),
                    'from_name' => 'fromName',
                    'from_email' => 'fromEmail',
                    'public_name' => 'publicName',
                    'custom_domain' => 'customDomain',
                    'head_domain' => 'headDomain',
                    'tracking_domain' => 'trackingDomain',
                    'reply_to_email' => 'replyToEmail',
                    'default_country_name' => 'defaultCountryName',
                    'list_template_id' => 1,
                    'approval_rules_id' => 2,
                    'approved_categories' => array('1', '2'),
                    'min_payout_parent_categories' => array('1' => '0.10', '2' => '0.10'),
                    'min_payout_child_categories' => array('1' => '0.10', '2' => '0.10'),
                    'is_enabled_for_c_p_m_bidding' => true,
                ),
            )
        );

        /** @var PublisherLists $lists */
        $lists = $this->deserialize(
            $listsArr,
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $lists);
        $this->assertCount(2, $lists);
    }
}
