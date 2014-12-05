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
use EBT\Collection\EmptyTrait;
use EBT\Collection\IterableTrait;
use EBT\Collection\GetItemsTrait;

/**
 * Interests
 */
class Interests implements CollectionInterface
{
    use CountableTrait;
    use EmptyTrait;
    use IterableTrait;
    use GetItemsTrait;

    /**
     * @var Interest[]
     */
    protected $items;

    /**
     * @param Interest[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
