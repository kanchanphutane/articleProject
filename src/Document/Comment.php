<?php
namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Comment 
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $authorname;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $comment;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $articleid;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $userid;  
    
    /**
     * @MongoDB\Field(type="date")
     */
    protected $createdAt;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    
    public function getAuthorname()
    {
        return $this->authorname;
    }

    public function setAuthorname($authorname)
    {
        $this->authorname = $authorname;
    }


    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getArticleid()
    {
        return $this->articleid;
    }

    public function setArticleid($articleid)
    {
        $this->articleid = $articleid;
    }

    public function getUserid()
    {
        return $this->userid;
    }

    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    public function getCreatedAt()
    { 
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) 
    { 
        $this->createdAt = $createdAt; 
        
    }
    
}