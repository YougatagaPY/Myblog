<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

   /**
    * @return Article[] Returns an array of Article objects
    */
   public function findByCategorie(Categorie $categorie): array
   {
       return $this->createQueryBuilder('a')
           ->join('a.categorie','c')
           ->andWhere('c.id = :val')
           ->setParameter('val', $categorie)
           ->orderBy('a.id', 'DESC')
           ->getQuery()
           ->getResult()
       ;
   }

     /**
    * @return Article[] Returns an array of Article objects
    */
    public function findRecent(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findArticlesByName(string $query)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->orX(
                        $qb->expr()->like('p.title', ':query'),
                        $qb->expr()->like('p.content', ':query'),
                    ),
                    $qb->expr()->isNotNull('p.created_at')
                )
            )
            ->setParameter('query', '%' . $query . '%')
        ;
        return $qb
            ->getQuery()
            ->getResult();
    }
    

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
