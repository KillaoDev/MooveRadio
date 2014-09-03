<?php

namespace Mr\BookBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Mr\BookBundle\Entity\Message;
use Mr\BookBundle\Entity\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MessageController extends Controller {
    public function listAction(Request $request, $page=1) {
        return $this->render('MrBookBundle:Message:list.html.twig', array(
            'messages' => $this->getRepMessage()->listPage($request->getLocale(), $page),
            'page' => $page,
            'nbMessages' => $this->getRepMessage()->count($request->getLocale()),
            'formCreate' => $this->getFormCreate()->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_BOOK_MANAGER')")
     */
    public function listAdminAction(Request $request, $page=1) {
        return $this->render('MrBookBundle:Message:list-admin.html.twig', array(
            'messages' => $this->getRepMessage()->listPage($request->getLocale(), $page),
            'nbMessages' => $this->getRepMessage()->count($request->getLocale())
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function createAction(Request $request) {
        /* @var $form Form */
        /* @var $message Message */
        /* @var $em ObjectManager */
        $form = $this->getFormCreate();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $message = $form->getData();
                $message->setDate(new \DateTime());
                $message->setLanguage($request->getLocale());
                $message->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();
                return $this->redirect($this->generateUrl('mr_book_list'));
            }
        }
        return $this->render('MrBookBundle:Message:form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Security("has_role('ROLE_NEWS_COMMENT')")
     */
    public function deleteAction(Request $request, $messageID) {
        /* @var $form Form */
        /* @var $message Message */
        /* @var $em ObjectManager */
        $message = $this->getRepMessage()->find($messageID);
        if ($message === null) {
            return $this->render('MrBookBundle:Message:not-found.html.twig', array(
                'action' => 'delete-message',
                'canonical' => $messageID
            ), new Response('', Response::HTTP_NOT_FOUND));
        }
        $form = $this->getFormDelete($messageID);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($message);
                $em->flush();
                return $this->redirect($this->generateUrl('mr_book_list'));
            }
        }
        return $this->render('MrBookBundle:Message:form-delete.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return MessageRepository
     */
    private function getRepMessage() {
        return $this->getDoctrine()->getRepository('MrBookBundle:Message');
    }

    /**
     * @return Form
     */
    public function getFormCreate() {
        return $this->createForm('mr_book_message',
                                 new Message(),
                                 array('action' => $this->generateUrl('mr_book_create')));
    }

    /**
     * @param $messageID
     * @return Form
     */
    public function getFormDelete($messageID) {
        return $this->createForm('mr_book_delete', array(),
                                 array('action' => $this->generateUrl('mr_book_delete',
                                                                      array('messageID' => $messageID))));
    }
}
