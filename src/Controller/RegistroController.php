<?php

namespace App\Controller;

use App\Entity\Etiquetas;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[Route('/api')]
class RegistroController extends AbstractController
{


    #[Route('/registro', name: 'registrar_usuario', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data['username'] == '') {
            return $this->json(['message' => 'Necesita un mínimo de 3 carácteres']);
        }

        $existingUser = $entityManager->getRepository(Usuario::class)->findOneBy(["username" => $data['username'], "email" => $data['email']]);

        if ($existingUser) {
            return $this->json(['message' => 'Ya existe un usuario con ese username']);
        }

        $user = new Usuario();
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setRolUsuario($data['id_rol_usuario']);
        $user->setComunidadAutonoma($data['comunidad_autonoma']);
        $user->setFoto($data['foto']);


        if (isset($data['etiquetas']) && is_array($data['etiquetas'])) {
            foreach ($data['etiquetas'] as $etiquetaId) {
                $etiquetaUsuario = $entityManager->getRepository(Etiquetas::class)->findOneBy(["descripcion" => $etiquetaId]);
                if ($etiquetaUsuario instanceof Etiquetas) {
                    $user->addEtiqueta($etiquetaUsuario);
                }
            }
        }

        $entityManager->persist($user);
        $entityManager->flush();



        return new JsonResponse(['message' => 'Usuario registrado con éxito. Se ha enviado un correo electrónico de confirmación.'], 201);
    }


}
