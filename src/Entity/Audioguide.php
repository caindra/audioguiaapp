<?php

namespace App\Entity;

use App\Repository\AudioguideRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AudioguideRepository::class)]
class Audioguide
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameEs = null;

    #[ORM\Column(length: 255)]
    private ?string $nameEn = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textEs = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $textEn = null;

    #[ORM\Column(type: 'blob')]
    /**
     * @var resource|null $audio
     */
    private $audioEs = null;

    #[ORM\Column(type: 'blob')]
    /**
     * @var resource|null $audio
     */
    private $audioEn = null;

    #[ORM\Column(type: 'blob')]
    /**
     * @var resource|null $image
     */
    private $image = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'audioguides')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEs(): ?string
    {
        return $this->nameEs;
    }

    public function setNameEs(?string $nameEs): Audioguide
    {
        $this->nameEs = $nameEs;
        return $this;
    }

    public function getNameEn(): ?string
    {
        return $this->nameEn;
    }

    public function setNameEn(?string $nameEn): Audioguide
    {
        $this->nameEn = $nameEn;
        return $this;
    }

    public function getTextEs(): ?string
    {
        return $this->textEs;
    }

    public function setTextEs(?string $textEs): Audioguide
    {
        $this->textEs = $textEs;
        return $this;
    }

    public function getTextEn(): ?string
    {
        return $this->textEn;
    }

    public function setTextEn(?string $textEn): Audioguide
    {
        $this->textEn = $textEn;
        return $this;
    }

    /**
     * @return resource|null
     */
    public function getAudioEs()
    {
        return $this->audioEs;
    }

    /**
     * @param resource|null $audioEs
     */
    public function setAudioEs($audioEs): void
    {
        $this->audioEs = $audioEs;
    }

    /**
     * @return resource|null
     */
    public function getAudioEn()
    {
        return $this->audioEn;
    }

    /**
     * @param resource|null $audioEn
     */
    public function setAudioEn($audioEn): void
    {
        $this->audioEn = $audioEn;
    }

    /**
     * @return resource|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param resource|null $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAudioguide($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAudioguide($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'Audioguía: ' . $this->nameEs . ' / Audioguide: ' . $this->nameEn;
    }


}
