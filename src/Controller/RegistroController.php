<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/api/registro')]
class RegistroController extends AbstractController
{
    #[Route('', name: "registrar_usuario", methods: ["POST"])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new Usuario();
        $user->setUsername($data['username']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setRol($data['rol']);

        $entityManager->persist($user);
        $entityManager->flush();


        return new JsonResponse(['message' => 'Usuario registrado con éxito'], 201);
    }


}
