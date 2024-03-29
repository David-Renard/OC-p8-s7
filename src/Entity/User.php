<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: 'email', message: "Un compte avec cette adresse mail existe déjà.")]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Vous devez saisir une adresse email.")]
    #[Assert\Email(message: "Le format de l'adresse n'est pas correcte.")]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\NotBlank(message: "Veuillez saisir un mot de passe.")]
    #[Assert\Length(
        min: 8,
        max: 50,
        minMessage: "Votre mot de passe doit avoir au moins {{ limit }} caractères.",
        maxMessage: "Votre mot de passe doit avoir au plus {{ limit }} caractères.",
    )]
    #[Assert\PasswordStrength(
        [
         "minScore" => Assert\PasswordStrength::STRENGTH_WEAK,
         "message"  => "Votre mot de passe est trop simple. Pour votre sécurité, changez-le."
        ]
    )]
    private string $plainPassword;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Task::class, orphanRemoval: true)]
    private Collection $tasks;


    public function __construct()
    {
        $this->tasks = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;

    }


    public function getEmail(): ?string
    {
        return $this->email;

    }


    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;

    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;

    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';


        return array_unique($roles);

    }


    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;

    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;

    }


    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;

    }


    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;

    }


    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;

    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here!
        // $this->plainPassword = null;
    }


    public function getUsername(): ?string
    {
        return $this->username;

    }


    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;

    }


    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;

    }


    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setAuthor($this);
        }

        return $this;

    }


    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // Set the owning side to null (unless already changed)!
            if ($task->getAuthor() === $this) {
                $task->setAuthor(null);
            }
        }

        return $this;

    }


}
