<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OSRepository")
 */
class OS
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
     * @ORM\Column(type="string", length=100)
     */
    private $version;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Platform", inversedBy="oS")
     * @ORM\JoinColumn(nullable=false)
     */
    private $platform_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vendor", inversedBy="oS")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendor_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language", inversedBy="oS")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Server", mappedBy="os_id")
     */
    private $servers;

    public function __toString()
    {
	return $this->getName() . " " .  $this->getVersion();
    }

    public function __construct()
    {
        $this->servers = new ArrayCollection();
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

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

    public function getPlatformId(): ?Platform
    {
        return $this->platform_id;
    }

    public function setPlatformId(?Platform $platform_id): self
    {
        $this->platform_id = $platform_id;

        return $this;
    }

    public function getVendorId(): ?Vendor
    {
        return $this->vendor_id;
    }

    public function setVendorId(?Vendor $vendor_id): self
    {
        $this->vendor_id = $vendor_id;

        return $this;
    }

    public function getLanguageId(): ?Language
    {
        return $this->language_id;
    }

    public function setLanguageId(?Language $language_id): self
    {
        $this->language_id = $language_id;

        return $this;
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

    /**
     * @return Collection|Server[]
     */
    public function getServers(): Collection
    {
        return $this->servers;
    }

    public function addServer(Server $server): self
    {
        if (!$this->servers->contains($server)) {
            $this->servers[] = $server;
            $server->setOsId($this);
        }

        return $this;
    }

    public function removeServer(Server $server): self
    {
        if ($this->servers->contains($server)) {
            $this->servers->removeElement($server);
            // set the owning side to null (unless already changed)
            if ($server->getOsId() === $this) {
                $server->setOsId(null);
            }
        }

        return $this;
    }

}