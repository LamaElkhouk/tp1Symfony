<?php

namespace App\Controller;

use App\Entity\Evenement;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;



class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
    #[Route('/panier/{nom}', name: 'app_panier')]
public function panier($nom = "", RequestStack $requestStack, SessionInterface $session): Response
{
    
    $session = $requestStack->getSession();

    // recuperer le panier depuis la session
    $panier = $session->get('panier', []);

    // on ajoute dans le panier si le nom est pas vide
    if (!empty($nom) && !in_array($nom, $panier)) {
        $panier[] = $nom;
        // mettre à jour le panier
        $session->set('panier', $panier);
        return $this->render('default/panier.html.twig', [
            'panier' => $panier,
        ]);
    } else {
        // si l'evenement est deja dans le panier
        return new Response('Cet événement est déjà dans votre panier.');
    }

}
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $rep=$form->getData();
            // Ajoutez un message flash
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            return $this->redirectToRoute('app_contact');
        }
    
        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/evenements', name: 'app_evenements')]
    public function evenements(): Response
    {
        $dateString = '2023-10-18';
        $date = DateTime::createFromFormat('Y-m-d', $dateString);
        $unEvenement = new Evenement('Teste affichage un evenement',$date,'img/dummies/560x300c.jpg','Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra.'); 
        $liste_evenement = $this->chargeDonnees();
        return $this->render('default/evenements.html.twig',['unEvenement'=>$unEvenement,'listeEvenement'=>$liste_evenement]);
    }
    #[Route('/evenements/{nom}', name: 'app_single')]
    public function unEvenement($nom): Response
    {
        $evenementTrouver=false;
        $liste_evenement = $this->chargeDonnees();
         // Recherchez l'événement par son nom dans la liste
        foreach ($liste_evenement as $evenement) {
            if ($evenement->getNom() === $nom) {
                $evenementTrouver=true;
                break;
            }
        }
        if ($evenementTrouver){
            return $this->render('default/single.html.twig', [
                'evenement' => $evenement,
            ]);
        }else{
            return new Response('evenement non trouvé : '.$evenement->getNom(), 404);
        }

    }

    private function chargeDonnees() {
        $ev1=new Evenement("test1",new \DateTime('2022-09-23'),"img/dummies/430x500a.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev2=new Evenement("test2",new \DateTime('2022-09-25'),"img/dummies/430x500b.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev3=new Evenement("test3",new \DateTime('2022-10-01'),"img/dummies/430x500c.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev4=new Evenement("test4",new \DateTime('2022-10-23'),"img/dummies/430x500d.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev5=new Evenement("test5",new \DateTime('2022-11-12'),"img/dummies/430x500e.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev6=new Evenement("test6",new \DateTime('2022-11-15'),"img/dummies/430x500f.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev7=new Evenement("test7",new \DateTime('2022-12-23'),"img/dummies/430x500a.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev8=new Evenement("test8",new \DateTime('2022-12-25'),"img/dummies/430x500b.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $ev9=new Evenement("test9",new \DateTime('2023-01-05'),"img/dummies/430x500c.jpg","Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aliquid beatae consectetur consequatur corporis, culpa delectus deserunt dolor dolorem dolorum ea exercitationem fuga id illum, incidunt iste iure, laborum libero modi natus nobis nulla officia officiis perferendis provident quam quasi quisquam quo quos repellendus saepe sunt temporibus totam unde veritatis vitae voluptas. Accusamus dignissimos, distinctio dolore enim eos esse est excepturi explicabo inventore libero pariatur perspiciatis quas quasi quod, sit? Accusamus amet assumenda atque distinctio eius expedita explicabo itaque labore magnam, magni molestias nobis non, pariatur perferendis quaerat qui sit veniam vero voluptatem voluptatum. Aliquid commodi debitis excepturi natus quas?");
        $evs=[$ev1,$ev2,$ev3,$ev4,$ev5,$ev6,$ev7,$ev8,$ev9];
        return $evs;
    }
}
