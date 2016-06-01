<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class IndexController extends Controller
{
    /**
     * @Route("/", name="app_index_index")
     */
    public function indexAction()
    {
        //return $this->render(':index:index.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        //$productos = $repository->findAll();
        //$productos = $repository->findByNovedad(1);//Bucar productos que sean novedad
        $productos = $repository->findByRef("B00000001");
        return $this->render(':index/portadas:novedades.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }


    public function portadaPromocionAction()
    {
        //return $this->render(':index:index.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Promocion');
        //$productos = $repository->findAll();
        //$productos = $repository->findByNovedad(1);//Bucar productos que sean novedad
        //$promocion = $repository->findById(1);
        $promocion = $repository->queryPromocionPortada();
        return $this->render(':index/portadas:promocion.html.twig',
            [
                'promocion' => $promocion,
            ]

        );
    }
    
    public function portadaIntersanteAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        //$productos = $repository->findAll();
        //$productos = $repository->findByNovedad(1);//Bucar productos que sean novedad
        $productos = $repository->findByRef("B00000002");
        return $this->render(':index/portadas:deinteres.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin", name="app_adm_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function empleadoIndexAction()
    {
        return $this->render(':index/empleado:index.html.twig');
    }

    /**
     * @Route("/imagenes", name="app_image_index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function mostrarImgAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Image');
        $images = $repository->findAll();
        return $this->render(':imagenes:index.html.twig',
            [
                'images' => $images,
            ]

        );
    }

    /**
     * @Route("/upload", name="app_index_upload")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function uploadAction(Request $request)
    {
        $p = new Image();
        $form = $this->createForm(ImageType::class, $p);

        if ($request->getMethod() == Request::METHOD_POST) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $m = $this->getDoctrine()->getManager();
                $m->persist($p);
                $m->flush();

                return $this->redirectToRoute('app_image_index');
            }
        }

        return $this->render(':index:upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
