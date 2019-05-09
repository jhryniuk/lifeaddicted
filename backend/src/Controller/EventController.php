<?php

namespace App\Controller;

use App\DTO\EventDTO;
use App\Entity\Event;
use App\Entity\Participant;
use App\Entity\User;
use App\Form\Type\EventType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController extends BaseController
{
    protected $entity = Event::class;
    protected $form = EventType::class;
    protected $dto = EventDTO::class;

    public function post(Request $request)
    {
        $serializer = $this->getSerializer();
        $form = $this->createForm($this->getForm());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $owner = $this->getDoctrine()
                ->getRepository(User::class)
                ->find(json_decode($request->getContent(), true)['owner']);
            $data->addOwner($owner);

            $participants = $this->getDoctrine()
                ->getRepository(Participant::class)
                ->findBy(['id' => json_decode($request->getContent(), true)['participants']]);

            foreach ($participants as $participant) {
                $data->addParticipant($participant);
            }

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

            $owner = $this->getDoctrine()
                ->getRepository(User::class)
                ->find(json_decode($request->getContent(), true)['owner']);
            $data->addOwner($owner);

            $participants = $this->getDoctrine()
                ->getRepository(Participant::class)
                ->findBy(['id' => json_decode($request->getContent(), true)['participants']]);

            $data->clearParticipant();
            foreach ($participants as $participant) {
                $data->addParticipant($participant);
            }

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