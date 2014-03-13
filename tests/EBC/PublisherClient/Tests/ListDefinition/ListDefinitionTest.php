<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Tests\ListDefinition;

use EBC\PublisherClient\ListDefinition\ListDefinition;
use EBC\PublisherClient\Tests\TestCase;

/**
 * ListDefinitionTest
 */
class ListDefinitionTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\ListDefinition\ListDefinition';

    public function testDeserialize()
    {
        /** @var ListDefinition $listDefinition */
        $listDefinition = $this->deserialize(
            array(
                'external_id' => 'ccc12',
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
                'approval_rules_name' => 'approvalRulesName',
                'approved_categories' => array('1', '2'),
                'min_payout_parent_categories' => array('1' => '0.10', '2' => '0.10'),
                'min_payout_child_categories' => array('1' => '0.10', '2' => '0.10'),
            ),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $listDefinition);
        $this->assertEquals('ccc12', $listDefinition->getExternalId());
        $this->assertEquals('list', $listDefinition->getName());
        $this->assertEquals('list description', $listDefinition->getDescription());
        $this->assertEquals(array('1', '2'), $listDefinition->getInterests());
        $this->assertEquals('fromName', $listDefinition->getFromName());
        $this->assertEquals('fromEmail', $listDefinition->getFromEmail());
        $this->assertEquals('publicName', $listDefinition->getPublicName());
        $this->assertEquals('customDomain', $listDefinition->getCustomDomain());
        $this->assertEquals('headDomain', $listDefinition->getHeadDomain());
        $this->assertEquals('trackingDomain', $listDefinition->getTrackingDomain());
        $this->assertEquals('replyToEmail', $listDefinition->getReplyToEmail());
        $this->assertEquals('defaultCountryName', $listDefinition->getDefaultCountryName());
        $this->assertEquals(1, $listDefinition->getListTemplateId());
        $this->assertEquals(2, $listDefinition->getApprovalRulesId());
        $this->assertEquals('approvalRulesName', $listDefinition->getApprovalRulesName());
        $this->assertEquals(array('1', '2'), $listDefinition->getApprovedCategories());
        $this->assertEquals(array('1' => '0.10', '2' => '0.10'), $listDefinition->getMinPayoutParentCategories());
        $this->assertEquals(array('1' => '0.10', '2' => '0.10'), $listDefinition->getMinPayoutChildCategories());
    }
}
