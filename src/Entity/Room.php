<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $memo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Building", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $building_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    static function getEntity(): ?string
    {
        return "Справочник 'Помещение'";
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

    public function getBuildingId(): ?Building
    {
        return $this->building_id;
    }

    public function setBuildingId(?Building $building_id): self
    {
        $this->building_id = $building_id;

        return $this;
    }
}
