<?php

namespace App\Repository;

use App\Entity\Product;
use App\Data\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Récupere les produits en lien avec une recherche
     * @return Product[]
     */
    public function findCategory(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category', 'c');

            if(!empty($search->categories)) {
                $query = $query
                    ->andWhere('c.id IN (:categories)')
                    ->setParameter('categories', $search->categories);
            }

            return $query->getQuery()->getResult();
        ;
    }

    /**
     * Récupere les produits en lien avec une recherche
     * @return Product[]
     */
    public function findSize(SearchData $search): array
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('s', 'p')
            ->join('p.size', 's');

            if(!empty($search->sizes)) {
                $query = $query
                    ->andWhere('s.id IN (:sizes)')
                    ->setParameter('sizes', $search->sizes);
            }

            return $query->getQuery()->getResult();
        ;
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
