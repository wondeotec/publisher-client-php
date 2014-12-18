<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Tiago Moutinho <tiago.moutinho@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\PublisherList;


class PublisherListStats
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var int
     */
    protected $totalSubscribers;

    /**
     * @var int
     */
    protected $totalUnsubscribes;

    /**
     * @var int
     */
    protected $totalBounces;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTotalSubscribers()
    {
        return $this->totalSubscribers;
    }

    /**
     * @return int
     */
    public function getTotalUnsubscribes()
    {
        return $this->totalUnsubscribers;
    }

    /**
     * @return int
     */
    public function getTotalBounces()
    {
        return $this->totalBounces;
    }
}
