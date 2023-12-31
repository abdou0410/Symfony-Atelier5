<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeUnit\FunctionUnit;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }
    public function orderByusername(){
        return $this ->createQueryBuilder('a')
        ->orderBy('a.username','Asc') //asendant (Desc) descendant
        ->getQuery()
        ->getResult();

    }

    public function searchbyalphabet(){
        return $this->createQueryBuilder('a')
        ->where('a.username LIKE :name')
        ->setParameter('name','a%')
        ->getQuery()
        ->getResult();
    }
    public function showAuthor()
    {
        return $this->createQueryBuilder('a')
        ->where('a.username LIKE : name')
        ->where('a.email LIKE :email')
        ->setParameters(['name'=>'a%','email'=>'%@%'])
        ->getQuery()
        ->getResult();
    }
    public function serachById($id){
        return $this->createQueryBuilder('a')
        ->join('a.books','b')
        ->addSelect('b')
        ->where('b.Author =: id')
        ->setParameter('id',$id)
        ->getQuery()
        ->getResult();

    }
    public function searchbyusername($username){
        return $this->createQueryBuilder('a')
        ->where('a.username =:name')
        ->setParameter('name',$username)
        ->getQuery()
        ->getResult();
    }

    public function minmax($min,$max){
       $em=$this->getEntityManager();
       return $em->createQuery('SELECT a from App\Entity\Author a where a.nbrlivre BETWEEN ?1 and :max')
       ->setParameters(['1'=>$min , 'max'=>$max])
       ->getResult();

       
    }
    public function orderbyemail(){
        return $this ->createQueryBuilder('a')
        ->orderBy('a.email','Asc') 
        ->getQuery()
        ->getResult();

    }
    public function findAuthorsWithNoBooks()
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.books', 'b')
            ->where('b.ref IS NULL')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
