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
 * Payout
 */
class Payout
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var float
     */
    protected $value;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }
}
