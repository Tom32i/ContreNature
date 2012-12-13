<?php

namespace Tom32i\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tom32i\SiteBundle\Form\SecretType;

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
    public function secretAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $entity = $user->getSecret();
        $editForm = $this->createForm(new SecretType(), $entity);

        return array(
            'user' => $user
        );
    }
}
