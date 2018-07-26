<?php

namespace BlogBundle\Service;

use BlogBundle\Entity\BlogPost;

class BlogPostSerializer
{
    /**
     * @param BlogPost $post
     * @return array
     */
    public function serializeShort(BlogPost $post): array
    {
        $serializedPost = [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'publishedAt'=> $post->getPublishedAt(),
            'isActive' => $post->isActive(),
        ];

        return $serializedPost;
    }

    public function serializeFull(BlogPost $post)
    {
        $serializedPost = $this->serializeShort($post) + [
            'text' => $post->getText(),
            'tags' => $post->getTags(),
        ];

        return $serializedPost;
    }
}