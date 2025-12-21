<?php
/**
 * @author Emile Camara <camara.emile@gmail.com>
 * @project  mon-agil
 */
declare(strict_types=1);

namespace App\ServiceType\UI\Http\Rest\ApiPlatform\Controller;

use App\Authorization\Application\Service\Authorizer;
use App\Authorization\Domain\ValueObject\Action;
use App\Authorization\Domain\ValueObject\Resource;
use App\Authorization\Infrastructure\Trait\AuthorizationTrait;
use App\ServiceType\Application\CreateServiceType\CreateServiceTypeCommand;
use App\ServiceType\Application\Response\ServiceTypeResponse;
use App\ServiceType\UI\Http\Rest\ApiPlatform\Input\CreateServiceTypeInput;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Infrastructure\Context\ContextService;
use App\Shared\Infrastructure\Service\File\LocalFileUploader;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class CreateServiceTypeController
{
    use AuthorizationTrait;

    public function __construct(
        private readonly Authorizer $authorizer,
        private readonly CommandBus $commandBus,
        private readonly ContextService $contextService,
        private readonly ValidatorInterface $validator,
        private readonly LocalFileUploader $localFileUploader
    ) {}

    /**
     * @throws \JsonException
     */
    public function __invoke(Request $request): mixed
    {
        // Vérification des autorisations
        $authorizationContext = $this->getAuthorizationContext(
            Resource::ServiceType,
            Action::Create,
            ['email' => $this->contextService->get('user')->username]
        );

        if (!$this->authorizer->authorize($authorizationContext)) {
            throw new AccessDeniedHttpException('Accès refusé pour créer un type de service');
        }

        // Création manuelle de l'input depuis la requête
        $input = $this->createInputFromRequest($request);

        // Validation de l'input
        $this->validateInput($input);
        $fileInfo = $this->localFileUploader->upload($input->file, $input->type, 'images/type_interventions/');
        /** @var ServiceTypeResponse $result */
        $result = $this->commandBus->dispatch(
            new CreateServiceTypeCommand(
                $input->name,
                $input->description,
                $fileInfo->newFileName,
                $input->taxRate,
                $input->additionalPercentage,
                $input->isQuotationEnable,
                $input->order,
                $this->contextService->get('user')->id,
            )
        );

        return  JsonResponse::fromJsonString(json_encode($result), 201);
    }

    private function createInputFromRequest(Request $request): CreateServiceTypeInput
    {
        $input = new CreateServiceTypeInput();

        // Récupération du fichier
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('Le fichier est requis');
        }
        $input->file = $uploadedFile;

        // Récupération des données du formulaire
        $input->name = $request->request->get('name', '');
        $input->description = $request->request->get('description', '');
        $input->type = $request->get('type');

        // Gestion du taxRate (nullable)
        $taxRate = $request->request->get('taxRate');
        $input->taxRate = $taxRate !== null && $taxRate !== ''
            ? (float) $taxRate
            : null;

        // Gestion des autres champs
        $input->additionalPercentage = (float) $request->request->get('additionalPercentage', 0);

        $input->isQuotationEnable = filter_var(
            $request->request->get('isQuotationEnable', 'false'),
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE
        ) ?? false;

        $input->order = (int) $request->request->get('order', 0);

        return $input;
    }

    private function validateInput(CreateServiceTypeInput $input): void
    {
        $errors = $this->validator->validate($input);

        if (count($errors) > 0) {
            $violations = [];
            foreach ($errors as $error) {
                $violations[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new BadRequestHttpException(
                json_encode([
                    'type' => 'validation_error',
                    'title' => 'Erreur de validation',
                    'violations' => $violations
                ], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            );
        }
    }
}
