<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Carrito;
use AppBundle\Entity\CarritoCopia;
use AppBundle\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CarritoController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="app_index_web")
     */
    public function indexAction($name)
    {
        return $this->render(':index:index.html.twig');
    }

    /**
     * @Route("/guarda_carrito/{id}", name="app_carrito_insertar")
     * @Security("has_role('ROLE_USER')")
     */
    public function insertarAction($id, Producto $producto)
    {

        $carrito = new Carrito();
        $carrito->setUsuario($this->getUser());

        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $producto = $repository->find($id);

        $carrito->setProducto($producto);

        $m->persist($carrito);
        $m->flush();

        return $this->redirectToRoute('app_index_web');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/comprar_producto/{id}", name="app_compra_producto")
     */
    public function precompraAction($id, Producto $producto)
    {
        $carrito = new Carrito();
        $carrito->setUsuario($this->getUser());

        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $producto = $repository->find($id);

        $carrito->setProducto($producto);

        $m->persist($carrito);
        $m->flush();

        return $this->redirectToRoute('app_lista_carrito');
    }

    /**
     * @Route("/confirmar_compra", name="app_carrito_comprar")
     * @Security("has_role('ROLE_USER')")
     */
    public function compraAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Carrito');
        $productos = $repo->findAll();

        for($i=0; $i<count($productos); $i++ ){
            $carritoCopia = new CarritoCopia();
            $carritoCopia->setUsuario($productos[$i]->getUsuario());
            $carritoCopia->setProducto($productos[$i]->getProducto());
            $m->persist($carritoCopia);
        }

        $m->flush();

        return $this->redirectToRoute('app_vaciar_lista');

    }

    public function cuentaPedidoAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Carrito');

        $pedidos = $repository->queryPedidoByUserId($this->getUser());
        return $this->render('UserBundle:Security:carrito.html.twig', [
            'pedidos' => $pedidos,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mi_lista", name="app_lista_carrito")
     * @Security("has_role('ROLE_USER')")
     */
    public function listaCompraAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Carrito');
        //$productos = $repository->findAll();
        $productos = $repository->queryListaProductoByUserId($this->getUser());
        return $this->render(':compra:index.html.twig', [
            'productos' => $productos
        ]);
    }

    /**
     * @Route("/remove_product_list/{id}", name="app_remove_product_list")
     * @ParamConverter(name="product", class="AppBundle:Carrito")
     */
    public function eliminarProductoListaAction(Carrito $carrito)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($carrito);
        $m->flush();
        return $this->redirectToRoute('app_lista_carrito');
    }

    /**
     * @Route("/vaciar_lista", name="app_vaciar_lista")
     */
    public function vaciarCarritoAction()
    {
        $m = $this->getDoctrine()->getManager();
        $carritoRepo = $m->getRepository('AppBundle:Carrito');

        $productos = $carritoRepo->findAll();

        foreach($productos as $prod){
            $m ->remove($prod);
        }

        //$m->remove($carrito);
        $m->flush();
        return $this->redirectToRoute('app_index_web');
    }
}
