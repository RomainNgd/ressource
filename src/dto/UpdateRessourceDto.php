<?php

namespace App\dto;

use App\Entity\RelationType;
use App\Entity\Ressource;
use App\Entity\RessourceCategory;
use App\Entity\RessourceType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

#[Uploadable]
class UpdateRessourceDto
{
    private Ressource $ressource;

    private ?string $title = null;

    private string $description = '';

    private string $content = '';

    private ?RessourceType $ressourceType = null;

    private bool $visible = false;

    #[UploadableField(mapping: 'ressources_image', fileNameProperty: "filePath")]
    private ?File $file = null;

    private ?string $filePath = null;

    private RessourceCategory $ressourceCategory;

    private RelationType $relationType;


    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return RessourceType|null
     */
    public function getRessourceType(): ?RessourceType
    {
        return $this->ressourceType;
    }

    /**
     * @param RessourceType|null $ressourceType
     */
    public function setRessourceType(?RessourceType $ressourceType): void
    {
        $this->ressourceType = $ressourceType;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     */
    public function setFile(?File $file): void
    {
        $this->file = $file;
    }

    /**
     * @return RessourceCategory
     */
    public function getRessourceCategory(): RessourceCategory
    {
        return $this->ressourceCategory;
    }

    /**
     * @param RessourceCategory $ressourceCategory
     */
    public function setRessourceCategory(RessourceCategory $ressourceCategory): void
    {
        $this->ressourceCategory = $ressourceCategory;
    }

    /**
     * @return RelationType
     */
    public function getRelationType(): RelationType
    {
        return $this->relationType;
    }

    /**
     * @param RelationType $relationType
     */
    public function setRelationType(RelationType $relationType): void
    {
        $this->relationType = $relationType;
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

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     */
    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
    }


}