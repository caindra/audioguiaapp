<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @method string getUserIdentifier()
 * @method string hashPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword)
 * @method bool isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword)
 * @method bool needsRehash(PasswordAuthenticatedUserInterface $user)
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, UserPasswordHasherInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $fullName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isAdmin = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isEditor = false;

    #[ORM\Column(nullable: true)]
    private ?bool $isLogged = false;

    #[ORM\ManyToMany(targetEntity: Audioguide::class, inversedBy: 'users')]
    private Collection $audioguides;

    public function __construct()
    {
        $this->audioguides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): User
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?bool $isAdmin): User
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    public function getIsEditor(): ?bool
    {
        return $this->isEditor;
    }

    public function setIsEditor(?bool $isEditor): User
    {
        $this->isEditor = $isEditor;
        return $this;
    }

    public function getIsLogged(): ?bool
    {
        return $this->isLogged;
    }

    public function setIsLogged(?bool $isLogged): User
    {
        $this->isLogged = $isLogged;
        return $this;
    }



    /**
     * @return Collection<int, Audioguide>
     */
    public function getAudioguides(): Collection
    {
        return $this->audioguides;
    }

    public function addAudioguide(Audioguide $audioguide): static
    {
        if (!$this->audioguides->contains($audioguide)) {
            $this->audioguides->add($audioguide);
        }

        return $this;
    }

    public function removeAudioguide(Audioguide $audioguide): static
    {
        $this->audioguides->removeElement($audioguide);

        return $this;
    }

    public function getRoles()
    {
        $roles = [];
        $roles[] = 'ROLE_USER';
        if ($this->getIsAdmin()) {
            $roles[] = 'ROLE_ADMIN';
        }
        if ($this->getIsEditor()) {
            $roles[] = 'ROLE_EDITOR';
        }
        return array_unique($roles);
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function __call(string $name, array $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
        // TODO: Implement @method string hashPassword(PasswordAuthenticatedUserInterface $user, string $plainPassword)
        // TODO: Implement @method bool isPasswordValid(PasswordAuthenticatedUserInterface $user, string $plainPassword)
        // TODO: Implement @method bool needsRehash(PasswordAuthenticatedUserInterface $user)
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('isAdmin', new Assert\Callback('validateAdminEditor'));
        $metadata->addPropertyConstraint('isEditor', new Assert\Callback('validateAdminEditor'));
    }

    public function validateAdminEditor(
        $value,
        ExecutionContextInterface $context,
        $payload)
    {
        if (($this->getIsAdmin() && !$this->getIsEditor()) || (!$this->getIsAdmin() && $this->getIsEditor())) {
            $context->buildViolation('Un usuario debe ser tanto Administrador como Editor, o ninguno.')
                ->addViolation();
        }
    }
}
