<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Marca;
use AppBundle\Form\MarcaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MarcaController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/marcas", name="app_marca_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Marca');
        $marcas = $repository->findAll();
        return $this->render(':marca:index.html.twig',
            [
                'marcas' => $marcas,
            ]
        );
    }

    /**
     * @Route(path="/insertarMarca", name="app_marca_insertar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertAction()
    {
        $marca = new Marca();
        $form = $this->createForm(MarcaType::class, $marca);
        return $this->render(':marca:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_marca_doInsertar')
            ]
        );
    }

    /**
     * @Route(path="/doInsertarMarca", name="app_marca_doInsertar")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function doInsertAction(Request $request)
    {
        $marca = new Marca();
        $form = $this->createForm(MarcaType::class, $marca);

        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m ->persist($marca);
            $m->flush();
            $this->addFlash('message','Marca insertada');

            return $this->redirectToRoute('app_marca_index');
        }

        $this->addFlash('message','Revisa el formulario');
        return $this->render(':marca:form.html.twig',
          [
              'form' => $form->createView(),
              'action' => $this->generateUrl('app_marca_doInsertar')
          ]
        );
    }
}
