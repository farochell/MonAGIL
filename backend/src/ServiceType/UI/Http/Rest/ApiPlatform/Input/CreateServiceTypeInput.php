<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\UI\Http\Rest\ApiPlatform\Input;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class CreateServiceTypeInput {

    #[Assert\NotNull(message: 'Le fichier est requis')]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'],
        mimeTypesMessage: 'Le fichier doit être une image valide (JPEG, PNG, WebP)'
    )]
    public UploadedFile $file;

    #[Assert\NotBlank(message: 'Le nom est requis')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères'
    )]
    public string $name;

    #[Assert\NotBlank(message: 'La description est requise')]
    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: 'La description doit contenir au moins {{ limit }} caractères',
        maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères'
    )]
    public string $description;

    #[Assert\PositiveOrZero(message: 'Le taux de taxe doit être positif ou zéro')]
    #[Assert\Range(
        notInRangeMessage: 'Le taux de taxe doit être entre {{ min }}% et {{ max }}%', min: 0, max: 100
    )]
    public ?float $taxRate = null;

    #[Assert\NotNull(message: 'Le pourcentage additionnel est requis')]
    #[Assert\Range(
        notInRangeMessage: 'Le pourcentage additionnel doit être entre {{ min }}% et {{ max }}%', min: 0, max: 100
    )]
    public float $additionalPercentage;

    #[Assert\NotNull(message: 'La valeur pour l\'activation du devis est requise')]
    #[Assert\Type(type: 'bool', message: 'La valeur doit être un booléen')]
    public bool $isQuotationEnable;

    #[Assert\NotNull(message: 'L\'ordre est requis')]
    #[Assert\PositiveOrZero(message: 'L\'ordre doit être positif ou zéro')]
    public int $order;

    #[Assert\NotBlank(message: 'Le type est requis')]
    #[Assert\Choice(
        choices: ['image', 'document'],
        message: 'Le type doit être "image" ou "document"'
    )]
    public string $type;
}
