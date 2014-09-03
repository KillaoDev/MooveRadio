<?php
namespace Mr\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends BaseController {
    public function getTokenAction() {
        return new Response($this->container->get('form.csrf_provider')->generateCsrfToken('authenticate'));
    }
}