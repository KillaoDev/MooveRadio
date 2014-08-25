<?php


namespace Mr\NewsBundle\Controller;


use Doctrine\Common\Persistence\ObjectManager;
use Mr\NewsBundle\Entity\Comment;
use Mr\NewsBundle\Entity\CommentRepository;
use Mr\NewsBundle\Entity\News;
use Mr\NewsBundle\Entity\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CommentController extends Controller {
    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function createAction(Request $request, $newsCanonical) {
        /* @var $form Form */
        /* @var $news News */
        /* @var $comment Comment */
        /* @var $em ObjectManager */
        $news = $this->getRepNews()->findByCanonical($newsCanonical, $request->getLocale());
        if ($news === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'create-comment',
                'canonical' => $newsCanonical
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            $form = $this->createForm('mr_news_comment', new Comment(),
                                      array('action' => $this->generateUrl('mr_news_comment_create',
                                                                           array('newsCanonical' => $newsCanonical))));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $comment = $form->getData();
                    $comment->setDate(new \DateTime());
                    $comment->setUser($this->getUser());
                    $news->addComment($comment);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($news);
                    $em->persist($comment);
                    $em->flush();
                    return $this->redirect($this->generateUrl('mr_news_read', array('canonical' => $news->getCanonical())));
                }
            }
            return $this->render('MrNewsBundle:Comment:form.html.twig', array('form' => $form->createView()));
        }
    }

    /**
     * @Security("has_role('ROLE_NEWS_COMMENT')")
     */
    public function deleteAction(Request $request, $commentID) {
        /* @var $form Form */
        /* @var $comment Comment */
        /* @var $em ObjectManager */
        $comment = $this->getRepComments()->find($commentID);
        if ($comment === null) {
            return $this->render('MrNewsBundle:News:not-found.html.twig', array(
                'action' => 'delete-comment',
                'canonical' => $commentID
            ), new Response('', Response::HTTP_NOT_FOUND));
        }
        $form = $this->createForm('mr_news_delete', array(),
                                  array('action' => $this->generateUrl('mr_news_comment_delete',
                                                                       array('commentID' => $commentID))));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $news = $comment->getNews();
                $em = $this->getDoctrine()->getManager();
                $em->remove($comment);
                $em->flush();
                return $this->redirect($this->generateUrl('mr_news_read', array('canonical' => $news->getCanonical())));
            }
        }
        return $this->render('MrNewsBundle:Comment:form-delete.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return NewsRepository
     */
    private function getRepNews() {
        return $this->getDoctrine()->getRepository('MrNewsBundle:News');
    }

    /**
     * @return CommentRepository
     */
    private function getRepComments() {
        return $this->getDoctrine()->getRepository('MrNewsBundle:Comment');
    }
} 