<?php

namespace App\Entity;

use App\Repository\AudioguideRepository;
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

    #[ORM\Column(length: 255)]
    private ?string $audioEs = null;

    #[ORM\Column(length: 255)]
    private ?string $audioEn = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

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

    public function getAudioEs(): ?string
    {
        return $this->audioEs;
    }

    public function setAudioEs(?string $audioEs): Audioguide
    {
        $this->audioEs = $audioEs;
        return $this;
    }

    public function getAudioEn(): ?string
    {
        return $this->audioEn;
    }

    public function setAudioEn(?string $audioEn): Audioguide
    {
        $this->audioEn = $audioEn;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): Audioguide
    {
        $this->image = $image;
        return $this;
    }


}
