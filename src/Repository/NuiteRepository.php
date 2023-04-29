<?php

namespace App\Repository;

use App\Entity\Nuite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Nuite>
 *
 * @method Nuite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nuite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nuite[]    findAll()
 * @method Nuite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NuiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nuite::class);
    }

    public function save(Nuite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Nuite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Nuite[] Returns an array of Nuite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneByIdInscription($inscription): ?array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.inscription = :val')
            ->setParameter('val', $inscription)
            ->getQuery()
            ->getResult()
        ;
    }
}
