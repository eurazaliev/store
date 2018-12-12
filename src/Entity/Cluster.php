<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClusterRepository")
 */
class Cluster
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="clusters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Clustertype", inversedBy="clusters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clustertype_id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Server", mappedBy="cluster_id")
     */
    private $servers;

    public function __toString()
    {
	return $this->getName();
    }

    public function __construct()
    {
        $this->servers = new ArrayCollection();
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

    public function getProjectId(): ?Project
    {
        return $this->project_id;
    }

    public function setProjectId(?Project $project_id): self
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getClustertypeId(): ?Clustertype
    {
        return $this->clustertype_id;
    }

    public function setClustertypeId(?Clustertype $clustertype_id): self
    {
        $this->clustertype_id = $clustertype_id;

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
            $server->setClusterId($this);
        }

        return $this;
    }

    public function removeServer(Server $server): self
    {
        if ($this->servers->contains($server)) {
            $this->servers->removeElement($server);
            // set the owning side to null (unless already changed)
            if ($server->getClusterId() === $this) {
                $server->setClusterId(null);
            }
        }

        return $this;
    }
}
