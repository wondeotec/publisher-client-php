<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\PublisherList;

use EBC\PublisherClient\PublisherList\PublisherList;
use EBC\PublisherClient\Tests\TestCase;

class PublisherListTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\PublisherList\PublisherList';

    public function testDeserialize()
    {
        /** @var PublisherList $list */
        $list = $this->deserialize(
            array(
                'id' => 'ccc12',
                'name' => 'list',
                'description' => 'list description',
                'interests' => array(
                    'items' => array(
                        array('id' => 20, 'name' => 'test1'),
                        array('id' => 30, 'name' => 'test2')
                    )
                ),
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
                'approval_rules_name' => 'approvalRulesName',
                'approved_categories' => array('1', '2'),
                'min_payout_parent_categories' => array('1' => '0.10', '2' => '0.10'),
                'min_payout_child_categories' => array('1' => '0.10', '2' => '0.10'),
            ),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $list);
        $this->assertEquals('ccc12', $list->getId());
        $this->assertEquals('list', $list->getName());
        $this->assertEquals('list description', $list->getDescription());
        $this->assertInstanceOf(
            'EBC\PublisherClient\PublisherList\Interests',
            $list->getInterests()
        );
        $this->assertEquals(2, count($list->getInterests()));
        $this->assertEquals('fromName', $list->getFromName());
        $this->assertEquals('fromEmail', $list->getFromEmail());
        $this->assertEquals('publicName', $list->getPublicName());
        $this->assertEquals('customDomain', $list->getCustomDomain());
        $this->assertEquals('headDomain', $list->getHeadDomain());
        $this->assertEquals('trackingDomain', $list->getTrackingDomain());
        $this->assertEquals('replyToEmail', $list->getReplyToEmail());
        $this->assertEquals('defaultCountryName', $list->getDefaultCountryName());
        $this->assertEquals(1, $list->getListTemplateId());
        $this->assertEquals(2, $list->getApprovalRulesId());
        $this->assertEquals('approvalRulesName', $list->getApprovalRulesName());
        $this->assertEquals(array('1', '2'), $list->getApprovedCategories());
        $this->assertEquals(array('1' => '0.10', '2' => '0.10'), $list->getMinPayoutParentCategories());
        $this->assertEquals(array('1' => '0.10', '2' => '0.10'), $list->getMinPayoutChildCategories());
    }
}
