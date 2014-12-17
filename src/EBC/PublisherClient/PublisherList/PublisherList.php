<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\PublisherList;

/**
 * List
 */
class PublisherList
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $interests;

    /**
     * @var string
     */
    protected $fromName;

    /**
     * @var string
     */
    protected $fromEmail;

    /**
     * @var string
     */
    protected $publicName;

    /**
     * @var string
     */
    protected $customDomain;

    /**
     * @var string
     */
    protected $headDomain;

    /**
     * @var string
     */
    protected $trackingDomain;

    /**
     * @var string
     */
    protected $replyToEmail;

    /**
     * @var string
     */
    protected $defaultCountryName;

    /**
     * @var int
     */
    protected $listTemplateId;

    /**
     * @var int
     */
    protected $approvalRulesId;

    /**
     * @var string
     */
    protected $approvalRulesName;

    /**
     * @var array
     */
    protected $approvedCategories;

    /**
     * @var array
     */
    protected $minPayoutParentCategories;

    /**
     * @var array
     */
    protected $minPayoutChildCategories;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @return string
     */
    public function getPublicName()
    {
        return $this->publicName;
    }

    /**
     * @return string
     */
    public function getCustomDomain()
    {
        return $this->customDomain;
    }

    /**
     * @return string
     */
    public function getHeadDomain()
    {
        return $this->headDomain;
    }

    /**
     * @return string
     */
    public function getTrackingDomain()
    {
        return $this->trackingDomain;
    }

    /**
     * @return string
     */
    public function getReplyToEmail()
    {
        return $this->replyToEmail;
    }

    /**
     * @return string
     */
    public function getDefaultCountryName()
    {
        return $this->defaultCountryName;
    }

    /**
     * @return int
     */
    public function getListTemplateId()
    {
        return $this->listTemplateId;
    }

    /**
     * @return int
     */
    public function getApprovalRulesId()
    {
        return $this->approvalRulesId;
    }

    /**
     * @return string
     */
    public function getApprovalRulesName()
    {
        return $this->approvalRulesName;
    }

    /**
     * @return array
     */
    public function getApprovedCategories()
    {
        return $this->approvedCategories;
    }

    /**
     * @return array
     */
    public function getMinPayoutParentCategories()
    {
        return $this->minPayoutParentCategories;
    }

    /**
     * @return array
     */
    public function getMinPayoutChildCategories()
    {
        return $this->minPayoutParentCategories;
    }
}
