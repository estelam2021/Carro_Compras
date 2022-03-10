<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController {
  /**
   * @Route("/article", name="article_list")
   */
    public function article(){
    
    $articles = $this->getDoctrine()->getRepository(Product::class)->findAll();

    return $this->render('articles/index.html.twig', array('articles' => $articles));
  }

  /**
 * @Route ("/article/new", name="new_article")
 * Method ({"GET", "POST"})
 */
public function new(Request $request, SluggerInterface $slugger){
  $article = new Product();

  $form = $this->createFormBuilder($article)
    ->add('name', TextType::class, array('required' =>true,'attr' =>array('class' => 'form-control')))
    ->add('precio', NumberType::class, array('required' =>true,'invalid_message'=> 'Valor inválido','attr' =>array('class' => 'form-control', 'placeholder' => 'Sin puntos ni comas...')))      
    ->add('cantidad', NumberType::class, array('invalid_message'=> 'Valor inválido','attr' =>array('class' => 'form-control')))            
    ->add('descripcion', TextareaType::class, array('required' =>true,'attr' =>array('class' =>'form-control')))
    ->add('imagen', FileType::class, array('required' =>false,'attr' =>array('class' =>'form-control', 'placeholder' => 'Seleccione una Imagen')))      
    ->add('save', SubmitType::class, array('label' =>'Create','attr' =>array('class'=>'btn btn-primary mt-3')))
    ->getForm();
  
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()){
      $brochureFile = $form->get('imagen')->getData();

      // this condition is needed because the 'brochure' field is not required
      // so the PDF file must be processed only when a file is uploaded
      if ($brochureFile) {
          $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
          // this is needed to safely include the file name as part of the URL
          $safeFilename = $slugger->slug($originalFilename);
          $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

          // Move the file to the directory where brochures are stored
          try {
              $brochureFile->move(
                  $this->getParameter('imagen_directory'),
                  $newFilename
              );
          } catch (FileException $e) {
              // ... handle exception if something happens during file upload
          }
      }

          // updates the 'brochureFilename' property to store the PDF file name
          // instead of its contents
        $article->setImagen($newFilename);
        $article = $form->getData();
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute('article_list');
    }
  
    return $this->render('articles/new.html.twig',array(
    'form'=>$form->createView()
  ));
}

/**
 * @Route ("/article/{id}", name= "article_show")
 * Method ({"GET"})
 */
public function show($id){
  $article = $this->getDoctrine()->getRepository(Product::class)->find($id);

  return $this->render('articles/show.html.twig', array('article' =>$article));

}

/**
 * @Route ("/article/update/{id}", name="update_article")
 * @Method ({"GET", "POST"})
 */
public function update(Request $request, $id){
    
    $article = $this->getDoctrine()->getRepository(Product::class)->find($id);

    $form = $this->createFormBuilder($article)
    ->add('name', TextType::class, array('required' =>true,'attr' =>array('class' => 'form-control')))
    ->add('precio', NumberType::class, array('required' =>true,'attr' =>array('class' => 'form-control', 'placeholder' => 'Sin puntos ni comas...')))      
    ->add('cantidad', NumberType::class, array('invalid_message'=> 'Valor inválido','attr' =>array('class' => 'form-control')))         
    ->add('descripcion', TextareaType::class, array('required' =>true,'attr' =>array('class' =>'form-control')))
    ->add('imagen', UrlType::class, array('required' =>false,'attr' =>array('class' =>'form-control', 'placeholder' => 'Url ...')))      
    ->add('save', SubmitType::class, array('label' =>'Update','attr' =>array('class'=>'btn btn-primary mt-3')))
    ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('article_list');
    }

    return $this->render('articles/update.html.twig',array('form'=>$form->createView()));  
}

/**
 * @Route ("/article/delete/{id}", name="delete_article")
 * Method ({"DELETE"})
 */
public function delete(Product $article){
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($article);
    $entityManager->flush();
    return $this->redirectToRoute('article_list');
}

}
