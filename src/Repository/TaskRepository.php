<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{

    private const LIMIT = 5;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findAllTasks(int $page, bool $isDone, string $anonymous, string $username): array
    {
        $tasks = [];
        if ($page < 1) $page = 1;

        $query = $this->createQueryBuilder('t')
            ->join('t.author', 'u')
            ->andWhere("u.username = :anonymous or u.username = :username")
            ->andWhere("t.isDone = :status")
            ->setParameter('status', $isDone)
            ->setParameter('username', $username)
            ->setParameter('anonymous', $anonymous)
            ->orderBy('t.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * self::LIMIT)
            ->setMaxResults(self::LIMIT)
            ->getQuery()
        ;

        $paginator = new Paginator($query);
        $data      = $paginator->getQuery()->getResult();

        if (empty($data)) {
            return $tasks;
        }

        // Set nbPages
        $pages = ceil($paginator->count() / self::LIMIT);

        if ($page > $pages) $page = $pages;
        // Set comments array
        $tasks['pages'] = $pages;
        $tasks['page']  = $page;
        $tasks['data'] = $data;
        return $tasks;
    }

//    public function findOneBySomeField($value): ?Task
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
