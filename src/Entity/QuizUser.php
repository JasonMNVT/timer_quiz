<?php

namespace App\Entity;

use App\Repository\QuizUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizUserRepository::class)]
class QuizUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizUsers')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'quizUsers')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'quiz_user', targetEntity: QuizUserResponse::class)]
    private Collection $quizUserResponses;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date = null;

    public function __construct()
    {
        $this->quizUserResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, QuizUserResponse>
     */
    public function getQuizUserResponses(): Collection
    {
        return $this->quizUserResponses;
    }

    public function addQuizUserResponse(QuizUserResponse $quizUserResponse): self
    {
        if (!$this->quizUserResponses->contains($quizUserResponse)) {
            $this->quizUserResponses->add($quizUserResponse);
            $quizUserResponse->setQuizUser($this);
        }

        return $this;
    }

    public function removeQuizUserResponse(QuizUserResponse $quizUserResponse): self
    {
        if ($this->quizUserResponses->removeElement($quizUserResponse)) {
            // set the owning side to null (unless already changed)
            if ($quizUserResponse->getQuizUser() === $this) {
                $quizUserResponse->setQuizUser(null);
            }
        }

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
