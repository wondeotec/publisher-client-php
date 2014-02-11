<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient\Campaign;

use EBC\PublisherClient\Advertiser\Advertiser;
use EBC\PublisherClient\Locale\Country;
use EBT\EBDate\EBDateTime;

/**
 * Campaign
 */
class Campaign
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Advertiser
     */
    protected $advertiser;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Schedule
     */
    protected $schedule;

    /**
     * @var Payout
     */
    protected $payout;

    /**
     * @var ListsApproval
     */
    protected $listsApproval;

    /**
     * @var Categories
     */
    protected $categories;

    /**
     * @var EBDateTime
     */
    protected $updatedAt;

    /**
     * @return int
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
     * @return Advertiser
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @return Payout
     */
    public function getPayout()
    {
        return $this->payout;
    }

    /**
     * @return ListsApproval|ListApproval[]
     */
    public function getListsApproval()
    {
        return $this->listsApproval;
    }

    /**
     * @return Categories|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return EBDateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
