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
 * ListApproval
 */
class ListApproval
{
    /**
     * @var int
     */
    protected $listId;

    /**
     * @var Approval
     */
    protected $approval;

    /**
     * @return int
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @return Approval
     */
    public function getApproval()
    {
        return $this->approval;
    }
}
