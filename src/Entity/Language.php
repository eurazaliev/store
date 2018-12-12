<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $memo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OS", mappedBy="language_id")
     */
    private $oS;

    public function __construct()
    {
        $this->oS = new ArrayCollection();
    }

    public function __toString()
    {
	return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(?string $memo): self
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * @return Collection|OS[]
     */
    public function getOS(): Collection
    {
        return $this->oS;
    }

    public function addO(OS $o): self
    {
        if (!$this->oS->contains($o)) {
            $this->oS[] = $o;
            $o->setLanguageId($this);
        }

        return $this;
    }

    public function removeO(OS $o): self
    {
        if ($this->oS->contains($o)) {
            $this->oS->removeElement($o);
            // set the owning side to null (unless already changed)
            if ($o->getLanguageId() === $this) {
                $o->setLanguageId(null);
            }
        }

        return $this;
    }
}
