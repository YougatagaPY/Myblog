<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Article;
use App\Repository\CategorieRepository;
use App\Repository\ArticleRepository;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarDumper\VarDumper;





class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    #[Route('/result', name: 'app_result')]
    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_leresult'))
            ->setMethod('POST')
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez un mot-clé'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/lereesult', name: 'app_leresult')]
    public function Leresult(Request $request, ArticleRepository $repo)
    {
        $formData = $request->request->get('query'); // Récupérer les données du formulaire
        $query = $formData['query'] ?? ''; // Accéder au champ "query" dans les données du formulaire
        $articles = [];
        dump($query);
        
        if ($query) {
            $articles = $repo->ShowSeach($query);
        }
        
        return $this->render('Search/index.html.twig', [
            'articles' => $articles
        ]);
    }

    
    

 



}
