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
}
