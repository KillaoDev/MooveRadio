<?php

namespace Mr\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller {
    public function homepageAction() {
        return $this->render('MrPageBundle:Homepage:home.html.twig');
    }
}
