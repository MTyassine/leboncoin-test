<?php

namespace CommercialBundle\Controller;

use CommercialBundle\Entity\CategorieArticle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categoriearticle controller.
 *
 */
class CategorieArticleController extends Controller
{
    /**
     * Lists all categorieArticle entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieArticles = $em->getRepository('CommercialBundle:CategorieArticle')->findAll();

        return $this->render('CommercialBundle:categoriearticle:index.html.twig', array(
            'categorieArticles' => $categorieArticles,
        ));
    }

    /**
     * Creates a new categorieArticle entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorieArticle = new Categoriearticle();
        $form = $this->createForm('CommercialBundle\Form\CategorieArticleType', $categorieArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $categorieArticle->setCreatedAt(new \DateTime());
            $categorieArticle->setUpdatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieArticle);
            $em->flush();

            return $this->redirectToRoute('categoriearticle_show', array('id' => $categorieArticle->getId()));
        }

        return $this->render('CommercialBundle:categoriearticle:new.html.twig', array(
            'categorieArticle' => $categorieArticle,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieArticle entity.
     *
     */
    public function showAction(CategorieArticle $categorieArticle)
    {
        $deleteForm = $this->createDeleteForm($categorieArticle);

        return $this->render('CommercialBundle:categoriearticle:show.html.twig', array(
            'categorieArticle' => $categorieArticle,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieArticle entity.
     *
     */
    public function editAction(Request $request, CategorieArticle $categorieArticle)
    {
        $deleteForm = $this->createDeleteForm($categorieArticle);
        $editForm = $this->createForm('CommercialBundle\Form\CategorieArticleType', $categorieArticle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $categorieArticle->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoriearticle_edit', array('id' => $categorieArticle->getId()));
        }

        return $this->render('CommercialBundle:categoriearticle:edit.html.twig', array(
            'categorieArticle' => $categorieArticle,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieArticle entity.
     *
     */
    public function deleteAction(Request $request, CategorieArticle $categorieArticle)
    {
        $form = $this->createDeleteForm($categorieArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieArticle);
            $em->flush();
        }

        return $this->redirectToRoute('categoriearticle_index');
    }

    /**
     * Creates a form to delete a categorieArticle entity.
     *
     * @param CategorieArticle $categorieArticle The categorieArticle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieArticle $categorieArticle)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categoriearticle_delete', array('id' => $categorieArticle->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
