<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/listar', name: 'listar_usuarios', methods: ['GET'])]
    public function listar(UsuarioRepository $usuarioRepository): JsonResponse
    {
        $usuarios = $usuarioRepository->findAll();

        return $this->json($usuarios);
    }

    #[Route('/{id}', name: 'usuario_by_id', methods: ['GET'])]
    public function getById(Usuario $usuario): JsonResponse
    {
        return $this->json($usuario);
    }

    #[Route('', name: 'crear_usuario', methods: ['POST'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario = new Usuario();
        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']);
        $usuario->setRolUsuario($data['rol']);
        $usuario->setActivo(true);

        $entityManager->persist($usuario);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update_usuario', methods: ['PUT'])]
    public function update(EntityManagerInterface $entityManager, Request $request, Usuario $usuario): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']);
        $usuario->setRolUsuario($data['rol']);
        $usuario->setActivo($data['activo']);

        $entityManager->flush();

        return $this->json(['message' => 'Usuario actualizado']);
    }

    #[Route('/borrar/{id}', name: 'borrar_usuario', methods: ['PUT'])]
    public function borrar(EntityManagerInterface $entityManager, Usuario $usuario): JsonResponse
    {
        $usuario->setActivo(false);
        $entityManager->flush();

        return $this->json(['message' => 'Usuario eliminado']);
    }

}
