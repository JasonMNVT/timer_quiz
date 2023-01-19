<?php

namespace App\Entity;

use App\Repository\QuizUserResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizUserResponseRepository::class)]
class QuizUserResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isValid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateResponse = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateValid = null;

    #[ORM\ManyToOne(inversedBy: 'quizUserResponses')]
    private ?QuizUser $quiz_user = null;

    #[ORM\ManyToOne(inversedBy: 'quizUserResponses')]
    private ?Question $question = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(?bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getDateResponse(): ?\DateTimeInterface
    {
        return $this->dateResponse;
    }

    public function setDateResponse(?\DateTimeInterface $dateResponse): self
    {
        $this->dateResponse = $dateResponse;

        return $this;
    }

    public function getDateValid(): ?\DateTimeInterface
    {
        return $this->dateValid;
    }

    public function setDateValid(?\DateTimeInterface $dateValid): self
    {
        $this->dateValid = $dateValid;

        return $this;
    }

    public function getQuizUser(): ?QuizUser
    {
        return $this->quiz_user;
    }

    public function setQuizUser(?QuizUser $quiz_user): self
    {
        $this->quiz_user = $quiz_user;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
