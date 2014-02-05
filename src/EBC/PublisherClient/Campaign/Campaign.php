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
     * @var Schedule
     */
    protected $schedule;

    /**
     * @var Bid
     */
    protected $bid;

    /**
     * @var ListApprovals
     */
    protected $listApprovals;

    /**
     * @var Categories
     */
    protected $categories;

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
     * @return Schedule
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * @return Bid
     */
    public function getBid()
    {
        return $this->bid;
    }

    /**
     * @return ListApprovals|ListApproval[]
     */
    public function getListApprovals()
    {
        return $this->listApprovals;
    }

    /**
     * @return Categories|Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
