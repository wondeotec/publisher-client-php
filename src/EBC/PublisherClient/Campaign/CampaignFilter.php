<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Diogo Rocha <diogo.rocha@emailbidding.com>
 * @copyright  2012-2014 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\Campaign;

/**
 * Class CampaignFilter
 *
 * This class is a Filter of Campaign, this represents for instance:
 *  age:
 *      12-13
 *      13-14
 *
 *  etc..
 */
class CampaignFilter
{
    /**
     * @var string[] array with the value_long of each filter (Male,Female...)
     */
    protected $valuesLong;

    /**
     * @var string[] array with the short_long of each filter (M,F...)
     */
    protected $valuesShort;

    /**
     * @var string, for instance age
     */
    protected $displayName;

    /**
     * @var string, for instance age_id
     */
    protected $name;

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getValuesLong()
    {
        return $this->valuesLong;
    }

    /**
     * @return string[]
     */
    public function getValuesShort()
    {
        return $this->valuesShort;
    }
}
