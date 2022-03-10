<?php


namespace App\Controller;
use App\Entity\Product;
use App\Entity\Pedidos;
use App\Repository\PedidosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping as ORM;


class CarritoController extends AbstractController
{
     /**
     * @Route("/view/cart", name="view_cart")
     */
    public function product(ManagerRegistry $doctrine)
    {
        
        $entityManager = $doctrine->getManager();
        $pedidos = new Pedidos();
        $pedidoAll = $entityManager->getRepository(Pedidos::class)->buscarPedidos();

        if(!empty($pedidoAll)){
            $sessionPedido = $pedidoAll;
            $this->get('session')->set('pedidos', $sessionPedido);
        }
        else{
            $pedidoAll="";
            $sessionPedido = $pedidoAll;
            $this->get('session')->set('pedidos', $sessionPedido);
        }
        return $this->render('home_user/mostrarCarrito.html.twig');
    }
    
    /**
     * @Route("/add/product/{id}", name="add_product")
     * @Method ({"GET", "POST"})
     */
    public function addProduct(Request $request, Product $article, ManagerRegistry $doctrine): Response
    {
        //$this->get('session')->clear();
        $sessionVal = $this->get('session')->get('article');

        $duplicateProduct = False; //para saber si un producto ya se encuentra en el carrito de compras
       
        $cantidad2 =  $request->request->get('cantidad'); //cantidad en unidades de un mismo producto que se desea agregar al carrito
        $color_ =  $request->request->get('color');
        $talla_ =  $request->request->get('talla');
        $talla = intval($talla_);
        $color = intval($color_);

        $idSesion = session_id();
        $entityManager = $doctrine->getManager();
        $pedidos = new Pedidos();

        $pedidos->setProductPedido($article->getId());
        $pedidos->setClienteSeccion($idSesion);
        $pedidos->setTallaPedido($talla);
        $pedidos->setColorPedido($color);
        $pedidos->setCantidadPedido($cantidad2);   
        $entityManager->persist($pedidos);
        $entityManager->flush();
       
        $pedidoAll = $entityManager->getRepository(Pedidos::class)->buscarPedidos();

        if(!empty($pedidoAll)){
            $article->setCantidad($cantidad2);
            $sessionVal[] = $article; 
            $sessionPedido = $pedidoAll;

            $this->get('session')->set('pedidos', $sessionPedido);
        }
        
        // Recuperar flashbag del controlador
        $flashbag = $this->get('session')->getFlashBag();

        // Agregar mensaje flash
        $flashbag->add("success", $article->getName() ." agregado al carrito...");
        
        return $this->redirectToRoute('view_cart');
        
    }
    
    
    /**
    * @Route ("/article/session/delete/{id}", name="delete_article_session")
    * @Method ({"DELETE"})
    */
    public function delete(Product $article, $id){
       
        $sessionArticle = $this->get('session')->get('article');   
        $sessionVal = null;
        
        foreach ($sessionArticle as $value)
        {
            if( $value->getId() != $id){
                 $sessionVal[] = $value;
            }
        }
        $this->get('session')->clear();

        $this->get('session')->set('article', $sessionVal);

        return $this->redirectToRoute('view_cart');
    
    }
    
   
}
