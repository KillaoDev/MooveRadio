<?php

namespace Mr\PageBundle\Controller;

use Mr\BookBundle\Entity\MessageRepository;
use Mr\NewsBundle\Entity\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {
    public function playerAction(Request $request) {
        return $this->render('MrPageBundle:Page:player.' . $request->getLocale() . '.html.twig');
    }

    public function privacyAction(Request $request) {
        return $this->render('MrPageBundle:Page:privacy.' . $request->getLocale() . '.html.twig');
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
