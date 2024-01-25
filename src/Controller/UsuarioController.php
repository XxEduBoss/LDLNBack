<?php

namespace App\Controller;

use App\Dto\UsuarioDTO;
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

        $listaUsuariosDTOs = [];

        foreach ($usuarios as $usuario){

            $user = new UsuarioDTO();
            $user->setId($usuario->getId());
            $user->setUsername($usuario->getUsername());
            $user->setPassword($usuario->getPassword());
            $user->setRolUsuario($usuario->getRolUsuario());
            $user->setActivo($usuario->isActivo());

            $listaUsuariosDTOs[] = $user;

        }


        return $this->json($listaUsuariosDTOs);
    }

    #[Route('/{id}', name: 'usuario_by_id', methods: ['GET'])]
    public function buscarPorId(Usuario $usuario): JsonResponse
    {
        return $this->json($usuario);
    }

    #[Route('/crear', name: 'crear_usuario', methods: ['POST', 'OPTIONS'])]
    public function crear(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if(empty($entityManager->getRepository(Usuario::class)->findBy(["username"=>$data['username']]))){
            $usuario = new Usuario();
            $usuario->setUsername($data['username']);
            $usuario->setPassword($data['password']);
            $usuario->setRolUsuario($data['id_rol']);
            $usuario->setActivo(true);
            $entityManager->persist($usuario);
            $entityManager->flush();
            return $this->json(['message' => 'Usuario creado'], Response::HTTP_CREATED);

        }else{

            return $this->json(['message' => 'Ya existe un usuario con ese username']);

        }

    }

    #[Route('/{id}', name: 'update_usuario', methods: ['PUT'])]
    public function update(EntityManagerInterface $entityManager, Request $request, Usuario $usuario): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $usuario->setUsername($data['username']);
        $usuario->setPassword($data['password']);
        $usuario->setRolUsuario($data['id_rol']);

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
