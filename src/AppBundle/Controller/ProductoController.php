<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use AppBundle\Entity\Departamento;
use AppBundle\Form\ProductoType;
use AppBundle\Form\VotosType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductoController extends Controller
{
    /**
     * @Route(path="/productos", name="app_producto_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $productos = $repository->findAll();
        return $this->render(':producto:index.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }

    /**
     * @Route(path="/insertProducto", name="app_producto_insert")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertAction()
    {
        $producto = new Producto();
        $form = $this->CreateForm(ProductoType::class, $producto);
        return $this->render(':producto:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_producto_doinsert')
            ]
        );
    }

    /**
     * @Route(path="/doInsert_producto", name="app_producto_doinsert")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public  function doInsertAction(Request $request)
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);

        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($producto);
            $m->flush();
            $this->addFlash('messages', 'producto añadido');
            return $this->redirectToRoute('app_producto_index');
        }

        $this->addFlash('messages', 'Revisa el formulario');
        return $this->render(':producto:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_producto_doinsert')
            ]
        );
    }

    /**
     * @Route(path="/modificar_producto/{id}", name="app_producto_modificar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modificarAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Producto');
        $producto = $repositorio->find($id);

        $form = $this->createForm(ProductoType::class, $producto);
        return $this->render(':producto:form.html.twig',
            [
               'form' => $form->createView(),
                'action' => $this->generateUrl('app_producto_domodificar', ['id' => $id])
            ]);
    }

    /**
     * @Route(path="/domodificar_producto/{id}", name="app_producto_domodificar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function domodificarAction(Request $request, $id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Producto');
        $producto = $repositorio->find($id);

        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        if($form->isValid()){
            $m->flush();
            $this->addFlash('message', 'Producto modificado');
            return $this->redirectToRoute('app_producto_index');
        }
        $this->addFlash('message','Comprueba el formulario');
        return $this->render(':producto:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('domodificar_producto/{id}', ['id' => $id])

            ]
        );
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/remove_product/{id}", name="app_remove_product")
     * @ParamConverter(name="product", class="AppBundle:Producto")
     */
    public function removeProductAction(Producto $product)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($product);
        $m->flush();
        return $this->redirectToRoute('app_producto_index');
    }

    /**
     * @Route("/especificacion/{id}", name="app_producto_especificacion")
     */
    public function espeficicacionAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $productos = $repository->queryProductoById($id);
        return $this->render(':producto:especificacionProducto.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }

    public function votarProductoAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Producto');
        $producto = $repositorio->find($id);

        $form = $this->createForm(VotosType::class, $producto, ['action' => $this->generateUrl('app_voto_producto', ['id' => $id])]);
        return $this->render(':producto:votos.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("votar/{id}", name="app_voto_producto")
     */
    public function doVotarProductoAction(Request $request, $id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Producto');
        $producto = $repositorio->find($id);
        //$producto->setPuntosMax(5);//Siempre inserta 5
        $form = $this->createForm(VotosType::class, $producto, ['action' => $this->generateUrl('app_voto_producto', ['id' => $producto->getId()])]);
        $form->handleRequest($request);

        if($form->isValid()){
            //$producto->setPuntosMax(5);//no inserta nada
            //$m->persist($product);
            $m->flush();

            //$this->addFlash('messages', 'comentario a?adido');
            return $this->redirectToRoute('app_producto_especificacion',['id' => $producto->getId()]);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function masVotadoAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');

        $voto = $repository->queryBestVoted();
        //return $this->render(':index/slider:mascomentado.html.twig',[
        return $this->render(':index/slider:mejorvalorado.html.twig',[
            'voto' => $voto,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * 
     */
    public function menuAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Departamento');


        $dep = $repository->findAll();
        return $this->render(':index:menu.html.twig',[
            'dep' => $dep,
        ]);
    }

    /**
     * @Route("/productos/{nombre}", name="app_lista_productos")
     */
    public function listaProductosAction($nombre)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        $productos = $repository->queryAllProductByDep($nombre);
        return $this->render(':producto:listaProducto.html.twig',[
            'productos' => $productos,
        ]);
    }
}
