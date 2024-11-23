<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\QueryBuilder;
/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

//    /**
//     * @return Event[] Returns an array of Event objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



    /**
     * Фильтрация событий по диапазону дат и дополнительным фильтрам.
     *
     * @param \DateTimeImmutable $startDate
     * @param \DateTimeImmutable $endDate
     * @param array $filters (например, по тегам, спорту и т.д.)
     * @return \Doctrine\ORM\QueryBuilder
     */
    /**
     * @extends ServiceEntityRepository<Event>
     */


    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('e');

        // Фильтрация по дате
        if (isset($filters['date'])) {
            if (isset($filters['date']['start'])) {
                $qb->andWhere('e.startDate >= :start_date')
                    ->setParameter('start_date', $filters['date']['start']);
            }
            if (isset($filters['date']['end'])) {
                $qb->andWhere('e.endDate <= :end_date')
                    ->setParameter('end_date', $filters['date']['end']);
            }
        }

        // Фильтрация по спорту
        if (isset($filters['sport'])) {
            $qb->andWhere('e.sport = :sport')
                ->setParameter('sport', $filters['sport']);
        }

        // Фильтрация по стране
        if (isset($filters['country'])) {
            $qb->andWhere('e.country = :country')
                ->setParameter('country', $filters['country']);
        }

        // Фильтрация по дивизиону
        if (isset($filters['division'])) {
            $qb->andWhere('e.division = :division')
                ->setParameter('division', $filters['division']);
        }

        // Фильтрация по тегам
        if (isset($filters['tags']) && count($filters['tags']) > 0) {
            $qb->join('e.tags', 't')
                ->andWhere('t.value IN (:tags)')
                ->setParameter('tags', $filters['tags']);
        }

        return $qb->getQuery()->getResult();
    }
}
