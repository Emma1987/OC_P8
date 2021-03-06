<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Task;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields="email", 
 *     message="Un compte existe déjà avec cet email."
 * )
 * @UniqueEntity(
 *     fields="username", 
 *     message="Ce nom d'utilisateur est déjà pris."
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     * @Assert\Length(
     *     max = 50, 
     *     maxMessage = "Le nom d'utilisateur ne peut dépasser 25 caractères."
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     * @Assert\Length(
     *     max = 60, 
     *     maxMessage = "L'adresse mail ne peut dépasser 60 caractères."
     * )
     */
    private $email;

    /**
     * @var Task[]|Collection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="user")
     */
    private $tasks;

    /**
     * @ORM\Column(type="json_array")
     * @Assert\NotBlank(message="Un rôle doit être choisi pour cet utilisateur.")
     */
    private $roles = [];

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Add task.
     *
     * @param Task $task
     *
     * @return User
     */
    public function addTask(Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task.
     *
     * @param Task $task
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTask(Task $task)
    {
        return $this->tasks->removeElement($task);
    }

    /**
     * Get tasks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
