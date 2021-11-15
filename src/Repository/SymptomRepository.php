<?php

namespace App\Repository;

use App\Entity\Symptom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Symptom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Symptom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Symptom[]    findAll()
 * @method Symptom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SymptomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Symptom::class);
    }

    public function findByName(string $name): ?Symptom
    {
        $name = trim(mb_strtolower($name));
        return $this->createQueryBuilder('s')
            ->andWhere('s.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByNameOrCreate(string $name)
    {
        $name = trim(mb_strtolower($name));
        $entity = $this->findByName($name);

        if (null === $entity) {
            $entity = new Symptom();
            $entity->setName($name);
            $this->_em->persist($entity);
            $this->_em->flush();
        }

        return $entity;
    }
}
