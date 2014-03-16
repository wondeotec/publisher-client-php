<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\ListApprovalExceptions;

use EBT\Collection\CollectionInterface;
use EBT\Collection\CountableTrait;
use EBT\Collection\DirectAccessTrait;
use EBT\Collection\EmptyTrait;
use EBT\Collection\GetItemsTrait;
use EBT\Collection\IterableTrait;

/**
 * ListsApprovalExceptions
 */
class ListsApprovalExceptions implements CollectionInterface
{
    use CountableTrait;
    use EmptyTrait;
    use GetItemsTrait;
    use IterableTrait;

    /**
     * @var ListApprovalExceptions[]
     */
    protected $items = array();
}
