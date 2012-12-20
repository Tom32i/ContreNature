<?php

namespace Tom32i\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tom32i\SiteBundle\Form\SecretType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $open = new DateTime() <= new DateTime('2012-12-31');

        $em = $this->getDoctrine()->getManager();

        $secrets = $em->getRepository('Tom32iSiteBundle:Secret')->findAll();

        if($open)
        {
            $done = 0;

            foreach ($secrets as $secret) 
            {
                $done += $secret->isComplete() ? 1 : 0;
            }

            return array(
                'done' => $done,
                'total' => count($secrets),
                'open' => $open,
            );
        }

        return array(
            'secrets' => $secrets,
            'open' => $open,
        );
    }

    /**
     * @Route("/secret", name="set_secret")
     * @Template()
     */
    public function secretAction(Request $request)
    {
        $closed = new DateTime() > new DateTime('2012-12-31');

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $secret = $user->getSecret();
        $form = $this->createForm(new SecretType(), $secret);

        if ( !$closed && $request->isMethod('POST')) 
        {
            $form->bind($request);

            if ($form->isValid()) 
            {
                $session = $this->get('session');
                $session->getFlashBag()->add('success', "Ton secret est bien gardé...");

                $em->persist($secret);
                $em->flush();
            }
        }

        return array(
            'user' => $user,
            'secret' => $secret,
            'form' => $form->createView(),
            'closed' => $closed,
        );
    }

    /**
     * @Route("/sudo/inviations", name="invitations")
     * @Template()
     */
    public function invitationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $mailer = $this->get('mailer');

        $users = $em->getRepository('Tom32iUserBundle:User')->findAll();
        $messages = array();

        foreach ($users as $key => $user) 
        {
            $messages[$key] = $this->sendInvitation($user, $mailer);
        }

        return array(
            'users' => $users,
            'messages' => $messages,
        );
    }

    /**
     * @Route("/sudo/user/{id}/inviations", name="user_invitation")
     * @Template("Tom32iSiteBundle:Default:invitations.html.twig")
     */
    public function invitationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mailer = $this->get('mailer');

        $user = $em->getRepository('Tom32iUserBundle:User')->find($id);

        if(!$user)
        {
            throw $this->createNotFoundException('Unable to find Secret entity.');
        }

        $message = $this->sendInvitation($user, $mailer);

        return array(
            'users' => array($user),
            'messages' => array($message),
        );
    }

    private function sendInvitation($user, $mailer)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("C'est contre nature !")
            ->setFrom('thomas.jarrand@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'Tom32iSiteBundle:Mail:invitation.html.twig',
                    array('user' => $user)
                )
                , 'text/html'
            )
        ; 

        return $mailer->send($message);
    }

    /**
     * @Route("/countdown", name="countdown")
     * @Template()
     */
    public function countdownAction()
    {
        return array();
    }
}
