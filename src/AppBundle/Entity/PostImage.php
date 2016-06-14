<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * PostImage.
 *
 * @ORM\Table(name="post_image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostImageRepository")
 */
class PostImage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
    * @var string
    *
    * @ORM\Column(name="image_name", type="string", length=255)
    */
    private $imageName;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    protected $image;

    public function setImageName($imageName)
    {
      $this->imageName = $imageName;

      return $this;
    }

    public function getImageName()
    {
      return $this->imageName;
    }
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return PostImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    public function setPost($post)
    {
        $this->post = $post;
        //no bun, crapa in controller. perfect <3 :)) mersi si scuze ca te tot deranjez

        return $this;
    }
    public function getPost()
    {
        return $this->post;
    }
}
