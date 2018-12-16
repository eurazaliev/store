<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServerRepository")
 */
class Server
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
     * @ORM\Column(type="boolean")
     */
    private $is_vm;

    /**
     * @ORM\Column(type="integer")
     */
    private $mem;

    /**
     * @ORM\Column(type="integer")
     */
    private $cpu;

    /**
     * @ORM\Column(type="integer")
     */
    private $hdd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $state_on_off;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ipaddr;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cluster", inversedBy="servers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cluster_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OS", inversedBy="servers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $os_id;

    static function getEntity(): ?string
    {
        return "Справочник 'Сервер'";
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

    public function getIsVm(): ?bool
    {
        return $this->is_vm;
    }

    public function setIsVm(bool $is_vm): self
    {
        $this->is_vm = $is_vm;

        return $this;
    }

    public function getMem(): ?int
    {
        return $this->mem;
    }

    public function setMem(int $mem): self
    {
        $this->mem = $mem;

        return $this;
    }

    public function getCpu(): ?int
    {
        return $this->cpu;
    }

    public function setCpu(int $cpu): self
    {
        $this->cpu = $cpu;

        return $this;
    }

    public function getHdd(): ?int
    {
        return $this->hdd;
    }

    public function setHdd(int $hdd): self
    {
        $this->hdd = $hdd;

        return $this;
    }

    public function getStateOnOff(): ?bool
    {
        return $this->state_on_off;
    }

    public function setStateOnOff(bool $state_on_off): self
    {
        $this->state_on_off = $state_on_off;

        return $this;
    }

    public function getIpaddr(): ?string
    {
        return $this->ipaddr;
    }

    public function setIpaddr(string $ipaddr): self
    {
        $this->ipaddr = $ipaddr;

        return $this;
    }

    public function getMemoo(): ?string
    {
        return $this->memoo;
    }

    public function setMemoo(?string $memoo): self
    {
        $this->memoo = $memoo;

        return $this;
    }

    public function getClusterId(): ?Cluster
    {
        return $this->cluster_id;
    }

    public function setClusterId(?Cluster $cluster_id): self
    {
        $this->cluster_id = $cluster_id;

        return $this;
    }

    public function getOsId(): ?OS
    {
        return $this->os_id;
    }

    public function setOsId(?OS $os_id): self
    {
        $this->os_id = $os_id;

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
}
