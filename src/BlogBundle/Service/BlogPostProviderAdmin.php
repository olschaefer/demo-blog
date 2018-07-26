<?php

namespace BlogBundle\Service;

use BlogBundle\Repository\BlogPostRepository;
use Doctrine\Common\Collections\Collection;

class BlogPostProviderAdmin extends BlogPostProviderPublic
{
    /**
     * @param $offset
     * @param $limit
     * @return Collection
     */
    public function getPosts($offset, $limit): Collection
    {
        return $this->blogPostRepository->findForAdminList($offset, $limit);
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->blogPostRepository->findCountForAdminList();
    }
}