<?php

namespace BlogBundle\Service;

use BlogBundle\Repository\BlogPostRepository;
use Doctrine\Common\Collections\Collection;

class BlogPostProviderPublic implements BlogPostProvider
{
    /**
     * @var BlogPostRepository
     */
    protected $blogPostRepository;

    /**
     * BlogPostProviderPublic constructor.
     * @param BlogPostRepository $repo
     */
    public function __construct(BlogPostRepository $repo)
    {
        $this->blogPostRepository = $repo;
    }

    /**
     * @param $offset
     * @param $limit
     * @return Collection
     */
    public function getPosts($offset, $limit): Collection
    {
        return $this->blogPostRepository->findForList($offset, $limit);
    }

    public function getCount(): int
    {
        return $this->blogPostRepository->findCountForList();
    }
}