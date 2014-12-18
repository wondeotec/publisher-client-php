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
     * @var int
     */
    protected $subscribers;

    /**
     * @var int
     */
    protected $unsubscribers;

    /**
     * @var int
     */
    protected $bounces;

    /**
     * @return int
     */
    public function getSubscribers()
    {
        return $this->subscribers;
    }

    /**
     * @return int
     */
    public function getUnsubscribers()
    {
        return $this->unsubscribers;
    }

    /**
     * @return int
     */
    public function getBounces()
    {
        return $this->bounces;
    }
}
