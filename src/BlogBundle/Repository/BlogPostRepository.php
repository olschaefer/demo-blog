<?php

namespace BlogBundle\Repository;

use BlogBundle\Entity\BlogPost;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;

class BlogPostRepository extends EntityRepository
{
    /**
     * @param $offset
     * @param int $limit
     * @return Collection
     */
    public function findForList($offset, $limit = 0): Collection
    {
        $criteria = new Criteria();
        $this->applyListCriteria($criteria);

        return $this->findPaginatedByCriteria($criteria, $offset, $limit);
    }

    /**
     * @return int
     */
    public function findCountForList(): int
    {
        return $this->findForList(0, 0)->count();
    }

    /**
     * @param $offset
     * @param int $limit
     * @return Collection
     */
    public function findForAdminList($offset, $limit = 0): Collection
    {
        $criteria = new Criteria();
        $this->applyAdminCriteria($criteria);

        return $this->findPaginatedByCriteria($criteria, $offset, $limit);
    }

    /**
     * @return int
     */
    public function findCountForAdminList(): int
    {
        return $this->findForAdminList(0, 0)->count();
    }

    /**
     * @param BlogPost $post
     */
    public function incrementViews(BlogPost $post)
    {
        /**
         * This method is implemented this way in order to avoid issues related to concurrent requests
         */
        $qb = $this->_em->createQueryBuilder();
        $qb->update(BlogPost::class, 'p')
            ->set('p.views', 'p.views+1')
            ->where('p.id = :id');

        $qb->getQuery()->execute(['id' => $post->getId()]);
        $post->incrementViews();
    }

    /**
     * @param Criteria $criteria
     * @param $offset
     * @param int $limit
     * @return Collection
     */
    private function findPaginatedByCriteria(Criteria $criteria, $offset, $limit = 0)
    {
        $criteria->setFirstResult($offset);
        if ($limit > 0) {
            $criteria->setMaxResults($limit);
        }

        return $this->matching($criteria);
    }

    /**
     * @param Criteria $criteria
     * @return void
     */
    private function applyListCriteria(Criteria $criteria): void
    {
        $criteria->where(Criteria::expr()->eq('isActive', true));
        $criteria->orderBy(['publishedAt' => 'DESC']);
    }

    /**
     * @param Criteria $criteria
     * @return void
     */
    private function applyAdminCriteria(Criteria $criteria): void
    {
        $criteria->orderBy(['id' => 'DESC']);
    }
}