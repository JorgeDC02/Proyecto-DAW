<?php

namespace Tienda\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Tienda\UserBundle\Entity\User;

class IndexController extends Controller
{
    /**
     * @Route("/usuarios", name="app_todosusuario_index")
     */
    public function indexAction()
    {
        $m = $this->getDoctrine()->getManager();

        $repository = $m->getRepository('UserBundle:User');

        //$usuarios = $repository->findAll();
        $usuarios = $repository->queryAllUsers();

        return $this->render(':index:usuarios.html.twig',
            [
                'usuarios' => $usuarios,
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/eliminar_usuario/{id}", name="app_usuario_delete")
     */
    public function eliminarUsuarioAction(User $usuario)
    {
        $m = $this->getDoctrine()->getManager();
        $m->remove($usuario);
        $m->flush();
        return $this->redirectToRoute('app_todosusuario_index');
    }

}
