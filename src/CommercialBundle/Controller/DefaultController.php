<?php

namespace CommercialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CommercialBundle:Default:index.html.twig');
    }
/*
    fonction : envoiyer mail au propriertaire de l'article
    artibue : request (fonction ajax pour recuperer les coordoner du client
    return : la vue de l'article en cour
*/
    public function mailArticleAction(Request $request)
    {

        $nom = $request->get('nom');
        $presnom = $request->get('presnom');
        $mail = $request->get('mail');
        $tel = $request->get('tel');
        $msg = $request->get('msg');
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('CommercialBundle:Article')->find($id);

        $message = \Swift_Message::newInstance()
            ->setSubject('nouveau contact pour ton article : '.$article->getNom())
            ->setFrom('leboncoin.mailing@gmail.com')
            ->setTo($article->getUser()->getEmail())
            ->setBcc('leboncoin.mailing@gmail.com')
            ->setBody(
                $this->renderView(
                    'CommercialBundle:mail:mail.html.twig'
                    ,array(
                        'article' => $article,
                        'nom' => $nom,
                        'prenom' => $presnom,
                        'mail' => $mail,
                        'tel' => $tel,
                        'msg' => $msg,
                        )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
        return $this->redirectToRoute('article_show', array('id' => $article->getId()));
    }
}
