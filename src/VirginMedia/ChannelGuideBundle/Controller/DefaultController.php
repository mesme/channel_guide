<?php

namespace VirginMedia\ChannelGuideBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VirginMedia\ChannelGuideBundle\Form\FilterType;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="home")
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $package = $region = null;

        //create form to show package and region drop downs
        $form = $this->createForm(new FilterType(), null, array(
            'action' => $this->generateUrl('home'),
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $package   = $form->get('package')->getData();
            $region    = $form->get('region')->getData();
        }

        //call service class to retrieve channel list based on the user selection on the landing page
        $channel_service = $this->get("channel_list");
        $channels = $channel_service->getChannels($package,$region);

        //if AJAX request send channel list in JSON to return the new set of records without having to reload the page
        if($request->isXmlHttpRequest())
        {
            return new JsonResponse($channels);
        }
        else
        {
            //first time landing page
            return array('form' => $form->createView(), 'channels' => $channels);
        }
    }
}
