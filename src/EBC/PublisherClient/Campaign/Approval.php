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
 * Approval
 */
class Approval
{
    const STATUS_APPROVED    = 'approved';
    const STATUS_LOW_PAYOUT  = 'low_payout';
    const STATUS_REJECTED    = 'rejected';
    const STATUS_UNAVAILABLE = 'unavailable';

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $type;

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * @return bool
     */
    public function isLowPayout()
    {
        return $this->status === self::STATUS_LOW_PAYOUT;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }

    /**
     * @return bool
     */
    public function isUnavailable()
    {
        return $this->status === self::STATUS_UNAVAILABLE;
    }
}
