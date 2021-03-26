<?php
namespace App\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @MongoDB\Document
 */
class Article
{

    const SERVER_PATH_TO_IMAGE_FOLDER = 'public/uploads/';

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $artName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $artDescription;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $artImage;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $publish;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $createdBy;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $updatedBy;

    // /**
    //  * @MongoDB\DateTime
    //  * @var string A "Y-m-d H:i:s" formatted value
    //  */

    /**
     * @MongoDB\Field(type="date")
     */
    protected $createdAt;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getArtName()
    {
        return $this->artName;
    }

    public function setArtName($artName)
    {
        $this->artName = $artName;
    }

    public function getArtDescription()
    {
        return $this->artDescription;
    }

    public function setArtDescription($artDescription)
    {
        $this->artDescription = $artDescription;
    }


    public function getArtImage()
    {
        return $this->artImage;
    }

    public function setArtImage($artImage)
    {
        $this->artImage = $artImage;
        return $this;
    }

    public function getPublish()
    {
        return $this->publish;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    public function getCreatedAt()
    { 
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) 
    { 
        $this->createdAt = $createdAt; 
        
    }

    public function getUpdatedAt()
    { 
        return $this->updatedAt; 
    }

    public function setUpdatedAt($updatedAt) 
    { 
        $this->updatedAt = $updatedAt; 
    }

    /**
     * @MongoDB\PrePersist()
     * @MongoDB\PreUpdate()
     */
    public function prePersist() {
        $this->setCreatedAt(new \DateTime());
    }
    


}

