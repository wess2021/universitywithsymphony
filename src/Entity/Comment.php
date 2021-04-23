<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
   
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

     /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Cour::class, inversedBy="comments")
     */
    private $cours_coments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getCoursComents(): ?Cour
    {
        return $this->cours_coments;
    }

    public function setCoursComents(?Cour $cours_coments): self
    {
        $this->cours_coments = $cours_coments;

        return $this;
    }
    public function __toString() {
        return $this->getContent();
    }
}
