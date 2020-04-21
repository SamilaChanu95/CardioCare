<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable  
{
    
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $facebookID;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $facebookAccessToken;

    /**
    * @ORM\Column(type="string", length=180, nullable=true)
    */
    private $githubID;

    /**
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $githubAccessToken;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getFacebookID(): ?string
    {
        return $this->facebookID;
    }

    public function setFacebookID($facebookID): void
    {
        $this->facebookID = $facebookID;

    }

    public function getFacebookAccessToken(): ?string
    {
        return $this->facebookAccessToken;
    }

    public function setFacebookAccessToken($facebookAccessToken): void
    {
        $this->facebookAccessToken = $facebookAccessToken;

    }

    public function getGithubID()
    {
        return $this->githubID;
    } 

    public function setGithubID($githubID): void
    {
        $this->githubID = $githubID;

    }

    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    public function setGithubAccessToken($githubAccessToken): void
    {
        $this->githubAccessToken = $githubAccessToken;

    }

    public function getRoles()
    {    
        return array('ROLE_USER');
    }

    public function eraseCredentials() 
    {
        $this->plainPassword = null;
    }

    public function getSalt() 
    {
        return null;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->email,
            $this->password
        
        ));
    }

    public function unserialize($string)
    {
        list (
            $this->id,
            $this->username,
            $this->email,
            $this->password,
        ) = unserialize($string);
    }

}
