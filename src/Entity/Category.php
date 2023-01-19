<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Question::class)]
    private Collection $questions;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: QuizUser::class)]
    private Collection $quizUsers;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->quizUsers = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setCategory($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getCategory() === $this) {
                $question->setCategory(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, QuizUser>
     */
    public function getQuizUsers(): Collection
    {
        return $this->quizUsers;
    }

    public function addQuizUser(QuizUser $quizUser): self
    {
        if (!$this->quizUsers->contains($quizUser)) {
            $this->quizUsers->add($quizUser);
            $quizUser->setCategory($this);
        }

        return $this;
    }

    public function removeQuizUser(QuizUser $quizUser): self
    {
        if ($this->quizUsers->removeElement($quizUser)) {
            // set the owning side to null (unless already changed)
            if ($quizUser->getCategory() === $this) {
                $quizUser->setCategory(null);
            }
        }

        return $this;
    }
}
