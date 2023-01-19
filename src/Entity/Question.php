<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Response::class)]
    private Collection $responses;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuizUserResponse::class)]
    private Collection $quizUserResponses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
        $this->quizUserResponses = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
     * @return Collection<int, Response>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setQuestion($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getQuestion() === $this) {
                $response->setQuestion(null);
            }
        }

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
            $quizUserResponse->setQuestion($this);
        }

        return $this;
    }

    public function removeQuizUserResponse(QuizUserResponse $quizUserResponse): self
    {
        if ($this->quizUserResponses->removeElement($quizUserResponse)) {
            // set the owning side to null (unless already changed)
            if ($quizUserResponse->getQuestion() === $this) {
                $quizUserResponse->setQuestion(null);
            }
        }

        return $this;
    }
}
