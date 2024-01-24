<?php

namespace App\Repository;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;

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

    public function __construct(ManagerRegistry $registry, private Security $security)
    {
        parent::__construct($registry, Task::class);
    }

    public function findTasks(int $page, bool $isDone): array
    {
        $tasks = [];
        $user = $this->security->getUser();

        if ($page < 1) $page = 1;

        $data = [];
        if ($user) {
            $query = $this->createQueryBuilder('t')
                ->andWhere("t.isDone = :status")
                ->setParameter('status', $isDone);
            if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
                $query->andWhere("t.author IS NULL or t.author = :id_author");
            } elseif (in_array(User::ROLE_USER, $user->getRoles())) {
                $query->andWhere("t.author = :id_author");
            }
            $query
                ->setParameter('id_author', $user)
                ->orderBy('t.createdAt', 'DESC')
                ->setFirstResult(($page - 1) * self::LIMIT)
                ->setMaxResults(self::LIMIT)
                ->getQuery()
            ;
            $paginator = new Paginator($query);
            $data      = $paginator->getQuery()->getResult();
        }


        if (empty($data)) {
            return $tasks;
        }

        // Set nbPages
        $pages = ceil($paginator->count() / self::LIMIT);

        if ($page > $pages) $page = $pages;
        // Set comments array
        $tasks['pages'] = $pages;
        $tasks['page']  = $page;
        $tasks['data']  = $data;
        return $tasks;
    }

//    public function findAnonymousTasks(bool $isDone): array
//    {
//        $query = $this->createQueryBuilder('t')
//            ->andWhere("t.isDone = :status")
//            ->andWhere("t.author IS NULL")
//            ->setParameter('status', $isDone)
//            ->getQuery()
//        ;
//
//        return $query->getResult();
//    }

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
