<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\Entity;

use Pim\Bundle\CatalogBundle\Entity\Family as PimFamily;

/**
 * Overrides original Family entity to add
 * the Shopware propertyGroup ID
 *
 * Class Family
 * @package Basecom\Bundle\ShopwareConnectorBundle\Entity
 */
class Family extends PimFamily
{
    /**
     * Shopware PropertyGroup ID
     *
     * @var integer
     */
    protected $swId;

    /**
     * @return int
     */
    public function getSwId()
    {
        return $this->swId;
    }

    /**
     * @param int $swId
     */
    public function setSwId($swId)
    {
        $this->swId = $swId;
    }
}
