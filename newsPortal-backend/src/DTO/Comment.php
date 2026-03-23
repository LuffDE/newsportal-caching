<?php
declare(strict_types=1);

namespace App\DTO;

class Comment extends AbstractJson
{
    private ?string $comment = null;
    private ?string $userName = null;
    private ?array $subComments = null;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): Comment
    {
        $this->comment = $comment;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): Comment
    {
        $this->userName = $userName;
        return $this;
    }

    public function getSubComments(): ?array
    {
        return $this->subComments;
    }

    public function setSubComments(?array $subComments): Comment
    {
        $this->subComments = $subComments;
        return $this;
    }


    public function toJsonArray(): void
    {
        parent::setup(get_object_vars($this));
    }
}