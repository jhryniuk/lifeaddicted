<?php

namespace App\Controller;

use App\DTO\DTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\YamlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class BaseController extends AbstractController
{
    public function index(Request $request)
    {
        $serializer = $this->getSerializer();
        $data = $this->getDoctrine()->getRepository($this->getEntity())->findAll();

        $dto = $this->getDTO();

        $dataArray = [];
        foreach ($data as $item) {
            $dto->set($item);
            $dataArray[] = $dto->toArray();
        }

        $serializedData = $serializer->serialize($dataArray, explode('/', $request->headers->get('Accept'))[1]);

        return new Response($serializedData, Response::HTTP_OK, [
            'Content-Type' => $request->headers->get('Accept'),
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    public function show(Request $request, $id)
    {
        $serializer = $this->getSerializer();
        $data = $this->getDoctrine()->getRepository($this->getEntity())->findById($id);
        $dto = $this->getDTO();
        $dto->set($data[0]);

        $serializedData = $serializer->serialize($dto->toArray(), explode('/', $request->headers->get('Accept'))[1]);

        return new Response($serializedData, Response::HTTP_OK, [
            'Content-Type' => $request->headers->get('Accept'),
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

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
                'Access-Control-Allow-Origin' => '*'
            ]);
        }

        return new Response('', Response::HTTP_BAD_REQUEST, [
            'Content-Type' => $request->headers->get('Accept'),
            'Access-Control-Allow-Origin' => '*'
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
                'Access-Control-Allow-Origin' => '*'
            ]);
        }

        return new Response('', Response::HTTP_BAD_REQUEST, [
            'Content-Type' => $request->headers->get('Accept'),
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    public function delete(Request $request, $id)
    {
        $serializer = $this->getSerializer();
        $data = $this->getDoctrine()->getRepository($this->getEntity())->findById($id);
        $entityManager = $this->getDoctrine()->getManager();


        $entityManager->remove($data[0]);
        $entityManager->flush();

        $dto = $this->getDTO();
        $dto->set($data[0]);

        $serializedData = $serializer->serialize($dto->toArray(), explode('/', $request->headers->get('Accept'))[1]);

        return new Response($serializedData, Response::HTTP_OK, [
            'Content-Type' => $request->headers->get('Accept'),
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    protected function getEntity()
    {
        return $this->entity;
    }

    protected function getForm()
    {
        return $this->form;
    }

    protected function getDTO(): DTO
    {
        return new $this->dto;
    }

    protected function getSerializer()
    {
        $encoders = [new CsvEncoder(), new XmlEncoder(), new JsonEncode(), new YamlEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return $serializer = new Serializer($normalizers, $encoders);
    }
}