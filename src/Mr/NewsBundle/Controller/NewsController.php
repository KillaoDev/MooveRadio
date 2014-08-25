<?php

namespace Mr\NewsBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Mr\NewsBundle\Entity\News;
use Mr\NewsBundle\Entity\NewsRepository;
use Mr\NewsBundle\Service\Canonicalizer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NewsController extends Controller {
    public function listAction(Request $request, $page=1) {
        return $this->render('MrNewsBundle:News:list.html.twig', array(
            'newsList' => $this->getRepNews()->listPage($request->getLocale(), $page)
        ));
    }

    /**
     * @Security("has_role('ROLE_NEWS_WRITER')")
     */
    public function listAdminAction(Request $request, $page=1) {
        return $this->render('MrNewsBundle:News:list-admin.html.twig', array(
            'newsList' => $this->getRepNews()->listPage($request->getLocale(), $page, false)
        ));
    }

    public function readAction(Request $request, $canonical) {
        $news = $this->getRepNews()->findByCanonical($canonical, $request->getLocale(), true);
        if ($news === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'read',
                'canonical' => $canonical
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            return $this->render('MrNewsBundle:News:read.html.twig', array(
                'news' => $news,
                'formComment' => $this->createForm(
                        'mr_news_comment',
                        null,
                        array('action' => $this->generateUrl('mr_news_comment_create',
                                                             array('newsCanonical' => $canonical)))
                    )->createView()
            ));
        }
    }

    /**
     * @Security("has_role('ROLE_NEWS_WRITER')")
     */
    public function readAdminAction(Request $request, $canonical) {
        $news = $this->getRepNews()->findByCanonical($canonical, $request->getLocale(), false);
        if ($news === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'read',
                'canonical' => $canonical
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            return $this->render('MrNewsBundle:News:read-admin.html.twig', array(
                'news' => $news
            ));
        }
    }

    /**
     * @Security("has_role('ROLE_NEWS_WRITER')")
     */
    public function createAction(Request $request) {
        /* @var $form Form */
        /* @var $news News */
        /* @var $em ObjectManager */
        $form = $this->createForm('mr_news_news', new News(), array(
            'action' => $this->generateUrl('mr_news_create')
        ));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $news = $form->getData();
                $news->setCanonical($this->getCanonicalizer()->canonicalize($news->getTitle(), function($canonical) use ($request) {
                    return $this->getRepNews()->findByCanonical($canonical, $request->getLocale());
                }));
                $news->setUser($this->getUser());
                $news->setLanguage($request->getLocale());
                if ($news->getActive()) {
                    $news->setDate(new \DateTime());
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();
                return $this->redirect($this->generateUrl('mr_news_read_admin', array('canonical' => $news->getCanonical())));
            }
        }
        return $this->render('MrNewsBundle:News:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_NEWS_WRITER')")
     */
    public function updateAction(Request $request, $canonical) {
        /* @var $form Form */
        /* @var $news News */
        /* @var $em ObjectManager */
        $news = $this->getRepNews()->findByCanonical($canonical, $request->getLocale(), false);
        if ($news === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'update',
                'canonical' => $canonical
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            $form = $this->createForm('mr_news_news', $news, array(
                'action' => $this->generateUrl('mr_news_update', array('canonical' => $canonical))
            ));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $news = $form->getData();
                    if ($news->getActive() && $news->getDate() === null) {
                        $news->setDate(new \DateTime());
                    }
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($news);
                    $em->flush();
                    return $this->redirect($this->generateUrl('mr_news_read_admin', array('canonical' => $news->getCanonical())));
                }
            }
            return $this->render('MrNewsBundle:News:form.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @Security("has_role('ROLE_NEWS_WRITER')")
     */
    public function deleteAction(Request $request, $canonical) {
        /* @var $form Form */
        /* @var $news News */
        /* @var $em ObjectManager */
        $news = $this->getRepNews()->findByCanonical($canonical, $request->getLocale(), false);
        if ($news === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'delete',
                'canonical' => $canonical
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            $form = $this->createForm('mr_news_delete', null, array(
                'action' => 'mr_news_list'
            ));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($news);
                    $em->flush();
                    return $this->redirect($this->generateUrl('mr_news_list_admin'));
                }
            }
            return $this->render('MrNewsBundle:News:form-delete.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @return NewsRepository
     */
    private function getRepNews() {
        return $this->getDoctrine()->getRepository('MrNewsBundle:News');
    }

    /**
     * @return Canonicalizer
     */
    private function getCanonicalizer() {
        return $this->get('mr_news.canonicalizer');
    }
}
