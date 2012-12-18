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
     * @Route("/")
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
}
