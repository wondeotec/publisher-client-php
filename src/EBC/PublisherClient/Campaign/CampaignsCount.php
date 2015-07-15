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

class CampaignsCount
{
    /**
     * @var int
     */
    protected $value;

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }
}
