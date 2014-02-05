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

use EBT\Collection\CollectionInterface;
use EBT\Collection\EmptyTrait;
use EBT\Collection\IterableTrait;
use EBT\Collection\CountableTrait;
use EBT\Collection\GetItemsTrait;

/**
 * ListsApproval
 */
class ListsApproval implements CollectionInterface
{
    use EmptyTrait;
    use IterableTrait;
    use CountableTrait;
    use GetItemsTrait;

    /**
     * @var ListApproval[]
     */
    protected $items;
}
