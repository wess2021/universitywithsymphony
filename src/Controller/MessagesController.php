<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
     /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {//pour les message on a utuliser one to many with user
        //avec deux attribut de liaison recieved et sender 
        //on va les recupier par user courent et qui a envoyer
        $message=new Messages;
        $form=$this->createForm(MessagesType::class,$message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());
            $em=$this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            $this->addFlash('message', 'message envoyer');
            return $this->redirectToRoute('messages');
        }
        return $this->render('messages/send.html.twig',[
            'form'=>$form->createView()
        ]);
    }
     /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        
        return $this->render('messages/received.html.twig',[
            
        ]);
    }
      /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        $message->setIsRead(true);
        $em=$this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();
                return $this->render('messages/read.html.twig', compact("message"));
    }
     /**
     * @Route("/delete/{id}", name="delete_message")
     */
    public function delete(Messages $message): Response
    {
        
        $em=$this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();
        return $this->redirectToRoute("received");
    }
}
