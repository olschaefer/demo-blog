<?php

namespace BlogBundle\Service;

use Doctrine\Common\Collections\Collection;

interface BlogPostProvider
{
    /**
     * @param $offset
     * @param $limit
     * @return Collection
     */
    public function getPosts($offset, $limit): Collection;

    /**
     * @return int
     */
    public function getCount(): int;
}