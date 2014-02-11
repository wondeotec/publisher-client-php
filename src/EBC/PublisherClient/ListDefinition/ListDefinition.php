<?php

/**
 * LICENSE: [EMAILBIDDING_DESCRIPTION_LICENSE_HERE]
 *
 * @author     Rui Ribeiro <rui.ribeiro@emailbidding.com>
 * @copyright  2012-2013 Emailbidding
 * @license    [EMAILBIDDING_URL_LICENSE_HERE]
 */

namespace EBC\PublisherClient\ListDefinition;

/**
 * ListDefinition
 */
class ListDefinition
{
    /**
     * @var string
     */
    protected $externalId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $externalId
     * @param string $name
     */
    public function __construct($externalId, $name)
    {
        $this->externalId = $externalId;
        $this->name       = $name;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
