<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
      * @var sting
      * @ORM\Column(name="name", type="string", length=50, unique=true)
      */
     private $name;

     /**
      * @var boolean
      * @ORM\Column(name="sanctions", type="boolean", options={"default":false})
      */
     private $sactions;

     /**
      * @var sting
      * @ORM\Column(name="memo", type="string", length=190, nullable=true)
      */
     private $memo;

     /**
      * @ORM\OneToMany(targetEntity="App\Entity\Vendor", mappedBy="country_id")
      */
     private $vendors;

     public function __construct()
     {
         $this->vendors = new ArrayCollection();
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

    public function getSactions(): ?bool
    {
        return $this->sactions;
    }

    public function setSactions(bool $sactions): self
    {
        $this->sactions = $sactions;

        return $this;
    }

    public function getMemo(): ?string
    {
        return $this->memo;
    }

    public function setMemo(string $memo): self
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * @return Collection|Vendor[]
     */
    public function getVendors(): Collection
    {
        return $this->vendors;
    }

    public function addVendor(Vendor $vendor): self
    {
        if (!$this->vendors->contains($vendor)) {
            $this->vendors[] = $vendor;
            $vendor->setCountryId($this);
        }

        return $this;
    }

    public function removeVendor(Vendor $vendor): self
    {
        if ($this->vendors->contains($vendor)) {
            $this->vendors->removeElement($vendor);
            // set the owning side to null (unless already changed)
            if ($vendor->getCountryId() === $this) {
                $vendor->setCountryId(null);
            }
        }

        return $this;
    }


}
