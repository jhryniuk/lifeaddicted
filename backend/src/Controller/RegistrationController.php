<?php

namespace App\Controller;

use App\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class);

        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $form->getData();

            try {
                $entityManager->persist($data);
                $entityManager->flush();
            } catch (\Exception $e) {
                return new Response("User: [{$form->getData()->getUserName()}] already exists.",
                    Response::HTTP_BAD_REQUEST,
                    ['Content-Type' => $request->headers->get('Accept')]
                );
            }

            return new Response($data, Response::HTTP_CREATED, [
                'Content-Type' => $request->headers->get('Accept'),
            ]);
        }

        return new Response('', Response::HTTP_BAD_REQUEST, [
            'Content-Type' => $request->headers->get('Accept'),
        ]);
    }
}