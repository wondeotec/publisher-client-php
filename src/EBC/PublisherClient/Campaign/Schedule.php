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

use EBT\EBDate\EBDateTime;

/**
 * Schedule
 */
class Schedule
{
    /**
     * @var EBDateTime
     */
    protected $startDate;

    /**
     * @var EBDateTime
     */
    protected $endDate;

    /**
     * @return EBDateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return EBDateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
