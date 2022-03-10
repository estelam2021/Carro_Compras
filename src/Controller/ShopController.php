<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Color;
use App\Entity\Tallas;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/", name="shop")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $article_shop = $em->getRepository(Product::class)->findAll();
        $color = $this->getDoctrine()->getRepository(Color::class)->findBy(array(), array('id' => 'ASC'));
        $tallas = $this->getDoctrine()->getRepository(Tallas::class)->findBy(array(), array('id' => 'ASC'));

        return $this->render('shop/index.html.twig', array(
        'article_shop' => $article_shop,
        'tallas' => $tallas,
        'color' => $color
        ));
    }
}
