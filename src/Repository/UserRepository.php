<?php
namespace App\Repository;

use App\Document\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry as MongoDBBundleManagerRegistry;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(PersistenceManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    
}


?>