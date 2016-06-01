<?php

namespace Tienda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NovedadesController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/novedades_index", name="app_novedades_index")
     */
    public function indexAction()
    {
        //return $this->render(':index:novedades.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        //$productos = $repository->findAll();
        $productos = $repository->findByNovedad(1);//Bucar productos que sean novedad

        return $this->render(':index:novedades.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }

    /**
     * @Route("/admin_novedad", name="app_index_empleado_index")
     */
    public function novedadesAction()
    {
        //return $this->render(':index:index.html.twig');
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Producto');
        //$productos = $repository->findAll();
        //$productos = $repository->findByNovedad(1);//Bucar productos que sean novedad
        $productos = $repository->findByNovedad(1);
        return $this->render(':producto:index.html.twig',
            [
                'productos' => $productos,
            ]

        );
    }

}
