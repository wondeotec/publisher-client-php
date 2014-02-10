<?php

/**
 * ListsDefinition.
 *
 * Collection of API Lists object.
 *
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\ListDefinition;

use EBT\Collection\CollectionInterface;
use EBT\Collection\CountableTrait;
use EBT\Collection\DirectAccessTrait;
use EBT\Collection\EmptyTrait;
use EBT\Collection\GetItemsTrait;
use EBT\Collection\IterableTrait;

/**
 * ListsDefinition
 */
class ListsDefinition implements CollectionInterface
{
    use CountableTrait;
    use EmptyTrait;
    use GetItemsTrait;
    use IterableTrait;

    /**
     * @var ListDefinition[]
     */
    protected $items = array();

    /**
     * @param ListDefinition[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
