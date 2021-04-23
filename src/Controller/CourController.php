<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Cour;
use App\Entity\SearchByName;
use App\Form\CommentType;
use App\Form\CourType;
use App\Form\SearchByNameType;
use App\Repository\CourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/cour")
 */
class CourController extends AbstractController
{
    /**
     * @Route("/", name="cour_index", methods={"GET"})
     */
    public function index(CourRepository $courRepository): Response
    {//definir tout les cours
        return $this->render('cour/index.html.twig', [
            'cours' => $courRepository->findAll(),
        ]);
    }
    /**
    * @Route("/search", name="serachbyname")
    */
public function SearchByName(Request $request){
    $SearchByName = new SearchByName();
    $form = $this->createForm(SearchByNameType::class, $SearchByName);
    $form->handleRequest($request);
    //initialement le tableau des cours est vide,c.a.d on affiche les cours que lorsque l'utilisateur clique sur le bouton rechercher
    $cours=[];
    if ($form->isSubmitted() && $form->isValid()) {
        //on récupère le nom du cour tapé dans le formulaire
        $nom = $SearchByName->getName();
        if ($nom!="") {
            //si on a fourni un nom du cour on affiche tous les cours ayant ce nom
            $cours= $this->getDoctrine()->getRepository(Cour::class)->findBy(['name'=>$nom]);
        } else {
            //si si aucun nom n'est fourni on affiche tous les cours
            $cours= $this->getDoctrine()->getRepository(Cour::class)->findAll();
        }
    }
        return $this->render('cour/search.html.twig', ['form'=>$form->createView(),'cours'=>$cours]);
    }

    /**
     * @Route("/new", name="cour_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cour = new Cour();
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);
//pour new cour on a utiliser courtype pour remplir formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            //condition sur formulaire
            if(!$cour->getId()){
                $cour->setDate( new \DateTime());
            }
            $imageFile =$form->get('fichier')->getData();
            //pour le fichier pdf import on a définir meme extension dans folder image directory
            $fileName=md5(uniqid()).'.'.$imageFile->guessExtension();
            $imageFile->move($this->getParameter('image_directory'),$fileName);
            $cour->setFichier($fileName);
           //on a utiliser doctrine et manager pour acceder au bd
            $entityManager = $this->getDoctrine()->getManager();
            //on a persister nos donné
            $entityManager->persist($cour);
            //refraichir notre bd
            $entityManager->flush();

            return $this->redirectToRoute('cour_index');
        }
//render to form page pour remplir formulaire
        return $this->render('cour/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="cour_show")
     */
    public function comment(Request $request, Cour $cour)
    {//mem chose pour commentaire il est integré dans cour show
        //il va commenter un cour specific
        $comment= new Comment();
        $entityManager = $this->getDoctrine()->getManager();
        $form= $this->createForm(CommentType::class,$comment);
  
        $form->handleRequest($request);
      
        if ($form->isSubmitted() && $form->isValid()){
            //condition sur commentaire et on définit la date du submit avec email de user current
            if(!$comment->getId()){
                
               
                $comment->setCreatedAt( new \DateTime())
                        ->setUsers($this->getUser())
                        ->setCoursComents($cour);
            }
            //on a persister au base de donné
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('cour_show',['id'=> $cour->getId()]);
        }
        return $this->render('cour/show.html.twig',[
            'cour'=>$cour,
            'coForm' =>$form->createView()
        ]);
    
    }
    

    /**
     * @Route("/{id}/edit", name="cour_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cour $cour): Response
    {
        $form = $this->createForm(CourType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cour_index');
        }

        return $this->render('cour/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cour_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cour $cour): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            //remove pour supprimé
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cour_index');
    }
    

  
  
}
