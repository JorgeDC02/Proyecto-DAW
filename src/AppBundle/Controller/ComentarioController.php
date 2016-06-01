<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 5/11/16
 * Time: 8:31 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comentario;
use AppBundle\Entity\Producto;
use AppBundle\Form\ComentarioType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ComentarioController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(name="app_comentario_index")
     */
    public function indexAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Comentario');
        //$comentarios = $repository->findAll();
        $comentarios = $repository->queryAllComments($id);
        return $this->render(':comentario:index.html.twig',
            [
                'comentarios' => $comentarios,
            ]
        );
    }

    public function insertarComentarioAction($id)
    {
        $comentario= new Comentario();
        $form = $this->createForm(ComentarioType::class, $comentario, ['action' => $this->generateUrl('app_comment_new', ['id' => $id])]);
        return $this->render(':comentario:form.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/new/{id}", name="app_comment_new")
     * @Method(methods={"POST"})
     */
    public function doinsertComentario(Request $request, Producto $product, $id)
    {
        $comentario = new Comentario();
        $form = $this->createForm(ComentarioType::class, $comentario, ['action' => $this->generateUrl('app_comment_new', ['id' => $product->getId()])]);
        //$form = $this->createForm(ComentarioType::class, $comentario, ['action' => $this->generateUrl('app_comment_new', ['id' => $id])]);

        $form->handleRequest($request);
        if($form->isValid()){
            $comentario->setUsuario($this->getUser());
            $comentario->setProducto($product);
            $m = $this->getDoctrine()->getManager();
            $m->persist($comentario);
            $m->flush();
            //$this->addFlash('messages', 'comentario a?adido');
            return $this->redirectToRoute('app_producto_especificacion',['id' => $product->getId()]);
        }
        //$this->addFlash('messages', 'Revisa el formulario');
        return $this->render(':comentario:form.html.twig',
            [
                'form' => $form->createView(),
                'action' => $this->generateUrl('app_comment_new')
            ]
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */
    public function masComentadoAction()
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Comentario');

        $comentario = $repository->queryMoreComment();
        return $this->render(':index/slider:mascomentado.html.twig',[
            'comentario' => $comentario,
        ]);
    }

    /**
     *
     * @Route("/comentariosAjax", name="app_usuario_comentarioAjax")
     */
    public function insertarComentarioAjaxAction()
    {
        /*$request = $this->container->get('request');
        $data = $request->query->get('dato');
        echo $data;
        return $data;*/

        /*$comentario = new Comentario();
        $comentario->setTexto('Prueba de comentario');

        $m = $this->getDoctrine()->getManager();
        $m->persist($comentario);
        $m->flush();*/

        return $this->render(':comentario:index.html.twig');
        //$prueba = "prueba";
        //return $prueba;
    }
}