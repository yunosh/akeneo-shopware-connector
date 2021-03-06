<?php

namespace Basecom\Bundle\ShopwareConnectorBundle\Entity\Repository;

use Doctrine\ORM\AbstractQuery;
use Pim\Bundle\CatalogBundle\Doctrine\ORM\Repository\ProductRepository as BaseRepository;

/**
 * @author  Amir El Sayed <elsayed@basecom.de>
 *
 * Class ProductRepository
 * @package Basecom\Bundle\ShopwareConnectorBundle\Entity\Repository
 */
class ProductRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    public function findIdByNotInSwId(array $swIds)
    {
        $qb = $this->createQueryBuilder('Product');
        $this->addJoinToValueTables($qb);
        $rootAlias = current($qb->getRootAliases());
        $qb->select($rootAlias.'.swProductId');
        $qb->andWhere(
            $qb->expr()->in($rootAlias.'.swProductId', ':swIds')
        );
        $qb->addGroupBy($rootAlias.'.id');
        $qb->setParameter(':swIds', $swIds);

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * @param array $mediaIds
     *
     * @return array
     */
    public function findProductMediaWithSwId(array $mediaIds)
    {
        $qb = $this->createQueryBuilder('Product');
        $this->addJoinToValueTables($qb);
        $qb->select('FileInfo.swMediaId');
        $qb->leftJoin('Value.media', 'FileInfo');
        $qb->andWhere(
            $qb->expr()->isNotNull('FileInfo.swMediaId')
        );
        $qb->andWhere(
            $qb->expr()->isNotNull('Product.swProductId')
        );
        $qb->orWhere(
            $qb->expr()->eq('Product.isVariant', '1')
        );
        $qb->andWhere(
            $qb->expr()->in('FileInfo.swMediaId', ':swIds')
        );
        $qb->setParameter(':swIds', $mediaIds);

        return $qb->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
    }
}
