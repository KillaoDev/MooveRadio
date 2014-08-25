<?php


namespace Mr\UserBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Mr\UserBundle\Entity\Team;
use Mr\UserBundle\Entity\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TeamController extends Controller {
    public function showAction(Request $request) {
        return $this->render('MrUserBundle:Team:list.html.twig', array(
            'teams' => $this->getRepTeam()->orderedList()
        ));
    }

    /**
     * @Security("has_role('ROLE_TEAM')")
     */
    public function listAction(Request $request) {
        return $this->render('MrUserBundle:Team:list-admin.html.twig', array(
            'teams' => $this->getRepTeam()->orderedList()
        ));
    }

    /**
     * @Security("has_role('ROLE_TEAM')")
     */
    public function createAction(Request $request) {
        /* @var $form Form */
        /* @var $team Team */
        /* @var $em ObjectManager */
        $form = $this->createForm('mr_user_team', new Team(), array(
            'action' => $this->generateUrl('mr_user_team_create')
        ));
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $team = $form->getData();
                $team->setLanguage($request->getLocale());
                $em = $this->getDoctrine()->getManager();
                $em->persist($team);
                $em->flush();
                return $this->redirect($this->generateUrl('mr_user_team_list'));
            }
        }
        return $this->render('MrUserBundle:Team:form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_TEAM')")
     */
    public function updateAction(Request $request, $teamid) {
        /* @var $form Form */
        /* @var $team Team */
        /* @var $em ObjectManager */
        $team = $this->getRepTeam()->find($teamid);
        if ($team === null) {
            return $this->render('MrUserBundle:Team:not-found.html.twig', array(
                'action' => 'update',
                'canonical' => $teamid
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            $originalUserteam = new ArrayCollection();
            foreach ($team->getUserteam() as $userteam) {
                $originalUserteam[] = $userteam;
            }
            $form = $this->createForm('mr_user_team', $team, array(
                'action' => $this->generateUrl('mr_user_team_update', array('teamid' => $teamid))
            ));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $team = $form->getData();
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($team);
                    foreach ($originalUserteam as $userteam) {
                        if ($team->getUserteam()->contains($userteam) === false) {
                            $em->remove($userteam);
                        }
                    }
                    $em->flush();
                    return $this->redirect($this->generateUrl('mr_user_team_list'));
                }
            }
            return $this->render('MrUserBundle:Team:form.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @Security("has_role('ROLE_TEAM')")
     */
    public function deleteAction(Request $request, $teamid) {
        /* @var $form Form */
        /* @var $team Team */
        /* @var $em ObjectManager */
        $team = $this->getRepTeam()->find($teamid);
        if ($team === null) {
            return $this->render('MrUserBundle:Team:not-found.html.twig', array(
                'action' => 'delete',
                'canonical' => $teamid
            ), new Response('', Response::HTTP_NOT_FOUND));
        } else {
            $form = $this->createForm('mr_user_delete', null, array(
                'action' => $this->generateUrl('mr_user_team_delete', array('teamid' => $teamid))
            ));
            if ($request->isMethod('POST')) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($team);
                    $em->flush();
                    return $this->redirect($this->generateUrl('mr_user_team_list'));
                }
            }
            return $this->render('MrUserBundle:Team:form-delete.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

    /**
     * @return TeamRepository
     */
    private function getRepTeam() {
        return $this->getDoctrine()->getRepository('MrUserBundle:Team');
    }
} 