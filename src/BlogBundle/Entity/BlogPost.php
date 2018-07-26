<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class BlogPost
 *
 * @ORM\Table(name="blog_posts",
 *     indexes={
 *         @ORM\Index(name="is_active_published_at_idx", columns={"is_active", "published_at"}),
 *         @ORM\Index(name="slug_idx", columns={"slug"})
 *     },
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="slug_uniq", columns={"slug"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\BlogPostRepository")
 * @UniqueEntity("slug")
 */
class BlogPost
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=150)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $text;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\NotBlank()
     */
    private $publishedAt;
    /**
     * @ORM\Column(type="array")
     */
    private $tags = [];
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $slug;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;
    /**
     * @ORM\Column(type="integer")
     */
    private $views = 0;


    /**
     * BlogPost constructor.
     */
    public function __construct()
    {
        $this->publishedAt = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param mixed $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    public function incrementViews()
    {
        $this->views++;
    }
}