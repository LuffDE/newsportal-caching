<?php
declare(strict_types=1);

namespace App\DTO;

class Image extends AbstractJson
{
    private ?string $copyright = null;
    private ?string $url = null;
    private ?string $caption = null;
    private ?string $alt = null;

    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    public function setCopyright(?string $copyright): Image
    {
        $this->copyright = $copyright;
        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): Image
    {
        $this->url = $url;
        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): Image
    {
        $this->caption = $caption;
        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(?string $alt): Image
    {
        $this->alt = $alt;
        return $this;
    }

    public function toJsonArray(): void
    {
        parent::setup(get_object_vars($this));
    }
}