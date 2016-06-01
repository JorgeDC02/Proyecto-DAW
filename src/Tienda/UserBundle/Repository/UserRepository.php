<?php
/**
 * (c) Ismael Tienda <i.trascastro@gmail.com>
 *
 * @link        http://www.ismaeltrascastro.com
 * @copyright   Copyright (c) Ismael Tienda. (http://www.ismaeltrascastro.com)
 * @license     MIT License - http://en.wikipedia.org/wiki/MIT_License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tienda\UserBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function myFindOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :username OR u.email = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function queryAllUsers()
    {
        return $this->createQueryBuilder('u')
            ->getQuery()
            ->execute()
            ;
    }

    public  function allUsers()
    {
        return $this->queryAllUsers()->execute();
    }
}