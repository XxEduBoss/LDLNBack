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

#[Route('/api')]
class RegistroController extends AbstractController
{

    #[Route('/registro', name: "registrar_usuario", methods: ["POST"])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if($data['username'] == ''){

            return $this->json(['message' => 'Necesita un mínimo de 3 carácteres']);

        }

        if (empty($entityManager->getRepository(Usuario::class)->findBy(["username" => $data['username'] and ["email" => $data['email']]]))) {
            $user = new Usuario();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
            $user->setRolUsuario($data['id_rol_usuario']);
            $user->setComunidadAutonoma($data['comunidad_autonoma']);

            if (isset($data['etiquetas']) && is_array($data['etiquetas'])) {
                foreach ($data['etiquetas'] as $etiquetaId) {
                    $etiquetaUsuario = $entityManager->getRepository(Etiquetas::class)->findOneBy(["descripcion"=>$etiquetaId] );
                    if ($etiquetaUsuario instanceof Etiquetas) {
                        $user->addEtiqueta($etiquetaUsuario);
                    }
                }
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse(['message' => 'Usuario registrado con éxito'], 201);

        }else {

            return $this->json(['message' => 'Ya existe un usuario con ese username']);
        }
    }

}
