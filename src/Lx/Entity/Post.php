<?php

namespace Lx\Entity;

/**
 * @Entity
 * @Table(name="post")
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Post
{
     /**
      * @Id
      * @Column(type="integer")
      * @GeneratedValue
      *
      * @var int
      */
    private $id;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $title;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    private $content;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }
}
