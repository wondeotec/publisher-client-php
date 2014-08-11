<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Campaign;

class CampaignFilters
{
    use EmptyTrait;
    use IterableTrait;
    use CountableTrait;
    use GetItemsTrait;

    /**
     * @var CampaignFilter[]
     */
    protected $items;
}
