<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity
 */
class Posts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    public $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=true)
     */
    public $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer", nullable=false)
     */
    private $authorId;

    /**
     * @var Users|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", inversedBy="posts", fetch="EAGER")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     */
    public $author;

    /**
     * @ORM\ManyToMany(targetEntity="Categories", mappedBy="posts")
     */
    private $categories;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value='')
    {
        $this->title = $value;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($value='')
    {
        $this->text = $value;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($value='')
    {
        $this->authorId = $value;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    //Этот метод тут потому что связь manyToMany не хочет сериализоваться 
    public function getCategoriesArray()
    {
        $result = [];
        foreach ($this->categories as $cat) {
            $result[]=["id"=>$cat->getId(), "name"=>$cat->category];
        }
        return $result;
    }
}

