<?php
namespace App\Document;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
// implements UserInterface
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @MongoDB\Document
 */
class User
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $firstname;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $lastname;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*\d).{3,8}$/i", message="Password is required to be min 3 chars in length & include atleast one letter & one number")
     */
    protected $password;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $gender;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $usertype;

    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }


    
    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    
    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    
    public function getUsertype()
    {
        return $this->usertype;
    }

    public function setUsertype($usertype)
    {
        $this->usertype = $usertype;
    }

    // /**
    //  * @see UserInterface
    //  */
    // public function getSalt()
    // {
    //     // not needed when using the "bcrypt" algorithm in security.yaml
    // }

    // /**
    //  * @see UserInterface
    //  */
    // public function eraseCredentials()
    // {
    //     // If you store any temporary, sensitive data on the user, clear it here
    //     // $this->plainPassword = null;
    // }

    // /**
    //  * @see UserInterface
    //  */
    // public function getRoles(): array
    // {
    //     $roles = $this->roles;
    //     // guarantee every user at least has ROLE_USER
    //     $roles[] = 'ROLE_USER';
    //     return array_unique($roles);
    // }

    // /**
    //  * A visual identifier that represents this user.
    //  *
    //  * @see UserInterface
    //  */
    // public function getUsername(): string
    // {
    //     return (string) $this->email;
    // }



}