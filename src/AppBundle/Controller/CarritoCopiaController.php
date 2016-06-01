<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 5/27/16
 * Time: 11:06 AM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\CarritoCopia;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CarritoCopiaController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function masCompradoAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:CarritoCopia');

        $compra = $repository->queryMoreBuyed();
        return $this->render(':index/slider:masvendido.html.twig',[
            'compra' => $compra,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/registro_compras", name="app_registro_compras")
     * @Security("has_role('ROLE_USER')")
     */
    public function listaRegistroCompraAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:CarritoCopia');
        //$productos = $repository->findAll();
        $productos = $repository->queryAllCompras();
        return $this->render(':compra:registro_compras.html.twig', [
            'productos' => $productos
        ]);
    }
}