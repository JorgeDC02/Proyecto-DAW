<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Producto;
use AppBundle\Entity\Promocion;
use AppBundle\Form\PromocionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PromocionController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/promociones", name="app_promocion_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        //return $this->render(':promociones:index.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Promocion');
        //$promociones = $repository->findAll();

        $promociones = $repository->queryAllPromocion();
        return $this->render(':promociones:index.html.twig',
            [
                'promociones' => $promociones,
            ]

        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lista_promociones", name="app_lista_promociones")
     */
    public function listaPromocionesAction()
    {
        //return $this->render(':promociones:index.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Promocion');
        //$promociones = $repository->findAll();

        $productos = $repository->queryListadoPromocion();
        return $this->render(':index:promociones.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }
    
    /**
     * @Route("/insertarPromo", name="app_insertar_promo")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertarPromoAction()
    {
        $promocion = new Promocion();
        //$promocion->setDescuentoDec(50);
        $form = $this->createForm(PromocionType::class, $promocion);
        return $this->render(':promociones:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_promocion_doinsertar')
            ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/precio/{id}")
     */
    public function precioProductoByProductoId($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repo = $m->getRepository('AppBundle:Promocion');

        $price = $repo->queryPrecioProductoByProductoId($id);
        return $this->render(':promociones:precio.html.twig',
            [
                'price' => $price,
            ]

        );
    }

    /**
     * @Route("/doinsertarPromo", name="app_promocion_doinsertar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function doinsertarPromo(Request $request)
    {
        $promocion = new Promocion();

        //$promocion->setDescuentoDec(50);
        $form = $this->createForm(PromocionType::class, $promocion);

        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            //$promocion->getId();

            //$m2 = $this->getDoctrine()->getManager();
            //$repository = $m2->getRepository('AppBundle:Producto');
            //$precio_producto = $repository->

                //$precioProducto = $repository->findById($promocion->getProduct());


                //$promocion ->setDescuentoDec($precio_producto);

            $m->persist($promocion);
            $m->flush();
            $this->addFlash('messages', 'Promocion añadida');
            return $this->redirectToRoute('app_promocion_index');
        }

        $this->addFlash('messages', 'Revisa el formulario');
        return $this->render(':promociones:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_promocion_doinsertar')
            ]
        );
    }

    /**
     * @Route(path="/modificar_promocion/{id}", name="app_promocion_modificar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function modificarPromoAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Promocion');
        $promocion = $repositorio->find($id);

        $form = $this->createForm(PromocionType::class, $promocion);
        return $this->render(':promociones:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_promocion_domodificar', ['id' => $id])
            ]);
    }

    /**
     * @Route(path="/domodificar_promocion/{id}", name="app_promocion_domodificar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function domodificarPromocionAction(Request $request, $id)
    {
        $m = $this->getDoctrine()->getManager();
        $repositorio = $m->getRepository('AppBundle:Promocion');
        $promocion = $repositorio->find($id);

        $form = $this->createForm(PromocionType::class, $promocion);
        $form->handleRequest($request);
        if($form->isValid()){
            $m->flush();
            $this->addFlash('message', 'Promocion modificada');
            return $this->redirectToRoute('app_promocion_index');
        }
        $this->addFlash('message','Comprueba el formulario');
        return $this->render(':promociones:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('domodificar_promocion/{id}', ['id' => $id])

            ]
        );
    }
}
