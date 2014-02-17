<?php

/**
 *
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Pedro Baptista <pedro.baptista@emailbidding.com>
 * @copyright  2013-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Campaign;

use EBT\Collection\CollectionInterface;
use EBT\Collection\EmptyTrait;
use EBT\Collection\IterableTrait;
use EBT\Collection\CountableTrait;
use EBT\Collection\GetItemsTrait;

/**
 * Creativities
 */
class Creativities implements CollectionInterface
{
    use EmptyTrait;
    use IterableTrait;
    use CountableTrait;
    use GetItemsTrait;

    /**
     * @var Creativity[]
     */
    protected $items;
}
