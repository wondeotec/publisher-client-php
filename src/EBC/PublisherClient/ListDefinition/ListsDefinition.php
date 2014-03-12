<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
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
}
