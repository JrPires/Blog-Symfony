<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="PostCollection")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="postCollection")
     * @ORM\JoinTable(name="categories_post")
     */
    private $categoryCollection;

    public function __construct()
    {
        $this->categoryCollection = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return Post
     */
    public function setTitle($title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return Post
     */
    public function setDescription($description): Post
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param $content
     * @return Post
     */
    public function setContent($content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return Post
     */
    public function setSlug($slug): Post
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     * @return Post
     */
    public function setStatus($status): Post
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt): Post
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt): Post
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $author
     * @return Post
     */
    public function setAuthor($author): Post
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return ArrayCollection|Category[]
     */
    public function getCategoryCollection()
    {
        return $this->categoryCollection;
    }

    /**
     * @param $categoryCollection
     * @return Post
     */
    public function setCategoryCollection(Category $categoryCollection): Post
    {
        if ($this->categoryCollection->contains($categoryCollection)) {
            return $this;
        }
        $this->categoryCollection[] = $categoryCollection;
        return $this;
    }
    
    public function __toString()
    {
        return $this->title;
    }
}
