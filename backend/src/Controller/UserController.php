<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    protected $entity = User::class;
    protected $form = UserType::class;
    protected $dto = UserDTO::class;

    public function post(Request $request)
    {
        $serializer = $this->getSerializer();
        $form = $this->createForm($this->getForm());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $dto = $this->getDTO();
            $dto->set($data);

            $serializedData = $serializer->serialize($dto->toArray(), explode('/', $request->headers->get('Accept'))[1]);

            return new Response($serializedData, Response::HTTP_CREATED, [
                'Content-Type' => $request->headers->get('Accept'),
            ]);
        }

        return new Response('', Response::HTTP_BAD_REQUEST, [
            'Content-Type' => $request->headers->get('Accept'),
        ]);
    }

    public function put(Request $request, $id)
    {
        $raw = $this->getDoctrine()->getRepository($this->getEntity())->findById($id);

        if (!$raw) {
            return new Response("No raw with id: $id", Response::HTTP_NOT_FOUND);
        }

        $serializer = $this->getSerializer();
        $form = $this->createForm($this->getForm(), $raw[0]);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $entityManager->persist($data);
            $entityManager->flush();

            $dto = $this->getDTO();
            $dto->set($data);

            $serializedData = $serializer->serialize($dto->toArray(), explode('/', $request->headers->get('Accept'))[1]);

            return new Response($serializedData, Response::HTTP_CREATED, [
                'Content-Type' => $request->headers->get('Accept'),
            ]);
        }

        return new Response('', Response::HTTP_BAD_REQUEST, [
            'Content-Type' => $request->headers->get('Accept'),
        ]);
    }
}