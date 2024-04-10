<?php

namespace App\dto;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Ressource;

class ShareDto
{
    private Ressource $ressource;

    private string $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return Ressource
     */
    public function getRessource(): Ressource
    {
        return $this->ressource;
    }

    /**
     * @param Ressource $ressource
     */
    public function setRessource(Ressource $ressource): void
    {
        $this->ressource = $ressource;
    }

}