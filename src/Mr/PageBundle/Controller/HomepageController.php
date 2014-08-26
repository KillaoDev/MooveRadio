<?php

namespace Mr\PageBundle\Controller;

use Mr\BookBundle\Entity\MessageRepository;
use Mr\NewsBundle\Entity\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller {
    public function homepageAction(Request $request) {
        return $this->render('MrPageBundle:Homepage:home.html.twig', array(
            'newsList' => $this->getRepNews()->findLast($request->getLocale(), 1),
            'messages' => $this->getRepMessage()->findLast($request->getLocale(), 5)
        ));
    }

    /**
     * @return NewsRepository
     */
    private function getRepNews() {
        return $this->getDoctrine()->getRepository('MrNewsBundle:News');
    }

    /**
     * @return MessageRepository
     */
    private function getRepMessage() {
        return $this->getDoctrine()->getRepository('MrBookBundle:Message');
    }
}
