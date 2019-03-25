<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchServerRepository")
 */
class SearchServer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isVm;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $memMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $memMax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cpuMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cpuMax;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hddMin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hddMax;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $onOff;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ipAddr;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cluster")
     */
    private $clusterId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OS")
     */
    private $osId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $count;

    static function getEntity(): ?string
    {
        return "Поиск 'сервер'";
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsVm(): ?bool
    {
        return $this->isVm;
    }

    public function setIsVm(?bool $isVm): self
    {
        $this->isVm = $isVm;

        return $this;
    }

    public function getMemMin(): ?int
    {
        return $this->memMin;
    }

    public function setMemMin(?int $memMin): self
    {
        $this->memMin = $memMin;

        return $this;
    }

    public function getMemMax(): ?int
    {
        return $this->memMax;
    }

    public function setMemMax(?int $memMax): self
    {
        $this->memMax = $memMax;

        return $this;
    }

    public function getCpuMin(): ?int
    {
        return $this->cpuMin;
    }

    public function setCpuMin(?int $cpuMin): self
    {
        $this->cpuMin = $cpuMin;

        return $this;
    }

    public function getCpuMax(): ?int
    {
        return $this->cpuMax;
    }

    public function setCpuMax(?int $cpuMax): self
    {
        $this->cpuMax = $cpuMax;

        return $this;
    }

    public function getHddMin(): ?int
    {
        return $this->hddMin;
    }

    public function setHddMin(?int $hddMin): self
    {
        $this->hddMin = $hddMin;

        return $this;
    }

    public function getHddMax(): ?int
    {
        return $this->hddMax;
    }

    public function setHddMax(?int $hddMax): self
    {
        $this->hddMax = $hddMax;

        return $this;
    }

    public function getOnOff(): ?bool
    {
        return $this->onOff;
    }

    public function setOnOff(?bool $onOff): self
    {
        $this->onOff = $onOff;

        return $this;
    }

    public function getIpAddr(): ?string
    {
        return $this->ipAddr;
    }

    public function setIpAddr(?string $ipAddr): self
    {
        $this->ipAddr = $ipAddr;

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

    public function getClusterId(): ?Cluster
    {
        return $this->clusterId;
    }

    public function setClusterId(?Cluster $clusterId): self
    {
        $this->clusterId = $clusterId;

        return $this;
    }

    public function getOsId(): ?OS
    {
        return $this->osId;
    }

    public function setOsId(?OS $osId): self
    {
        $this->osId = $osId;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
