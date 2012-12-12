<?php

namespace Tom32i\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

        return array(
            'user' => $user
        );
    }
}
