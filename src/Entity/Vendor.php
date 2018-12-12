<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VendorRepository")
 */
class Vendor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $permit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country", inversedBy="vendors")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OS", mappedBy="vendor_id")
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

    public function getPermit(): ?bool
    {
        return $this->permit;
    }

    public function setPermit(?bool $permit): self
    {
        $this->permit = $permit;

        return $this;
    }

    public function getCountryId(): ?Country
    {
        return $this->country_id;
    }

    public function setCountryId(?Country $country_id): self
    {
        $this->country_id = $country_id;

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
            $o->setVendorId($this);
        }

        return $this;
    }

    public function removeO(OS $o): self
    {
        if ($this->oS->contains($o)) {
            $this->oS->removeElement($o);
            // set the owning side to null (unless already changed)
            if ($o->getVendorId() === $this) {
                $o->setVendorId(null);
            }
        }

        return $this;
    }
}
