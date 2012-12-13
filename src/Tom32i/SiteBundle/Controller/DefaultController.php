<?php

namespace Tom32i\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tom32i\SiteBundle\Form\SecretType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/secret", name="set_secret")
     * @Template()
     */
    public function secretAction(Request $request)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $secret = $user->getSecret();
        $form = $this->createForm(new SecretType(), $secret);

        if ($request->isMethod('POST')) 
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
        );
    }
}
