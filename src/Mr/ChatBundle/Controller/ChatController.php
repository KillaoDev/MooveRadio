<?php

namespace Mr\ChatBundle\Controller;

use Mr\ChatBundle\Entity\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {
    public function viewAction(Request $request) {
        return $this->render('MrChatBundle:View:index.html.twig', array(
            'messages' => $this->getRepMessage()->findLast($request->getLocale(), 25)
        ));
    }

    /**
     * @return MessageRepository
     */
    private function getRepMessage() {
        return $this->getDoctrine()->getRepository('MrChatBundle:Message');
    }
}
