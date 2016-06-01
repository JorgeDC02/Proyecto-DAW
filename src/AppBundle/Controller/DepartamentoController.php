<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Departamento;

use AppBundle\Form\DepartamentoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class DepartamentoController extends Controller
{
    /**
     * @Route(path="/departamentos", name="app_departamento_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();

        $repository = $m->getRepository('AppBundle:Departamento');

        $departamentos = $repository->findAll();

        return $this->render(':departamento:index.html.twig',
            [
                'departamentos' => $departamentos,
            ]
        );
    }

    /**
     * @Route(path="/insert_departamento", name="app_departamento_insert")
     * @Security("has_role('ROLE_ADMIN')")
     *
     */
    public function insertAction()
    {
        $departamento= new Departamento();
        $form = $this->createForm(DepartamentoType::class, $departamento);
        return $this->render(':departamento:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_departamento_doinsert')
            ]
        );
    }

    /**
     * @Route(path="/doinsert_departamento", name="app_departamento_doinsert")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function doInsertAction(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm(DepartamentoType::class, $departamento);

        $form->handleRequest($request);
        if($form->isValid()){
            $m = $this->getDoctrine()->getManager();
            $m->persist($departamento);
            $m->flush();
            $this->addFlash('messages', 'Departamento añadido');
            return $this->redirectToRoute('app_departamento_index');
        }
        $this->addFlash('messages', 'Revisa el formulario');
        return $this->render(':departamento:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_departamento_doinsert')
            ]
        );
    }
}
