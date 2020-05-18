<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use App\Entity\Consultant;

class SearchController extends AbstractController
{
    /**
     * @Route("/searchItem", name="search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.context')->getToken()->getUser();

        $tabsearch = [];
        $search = $request->request->get('recherche');

        if ($search == null) {
            $searchresult = $em->getRepository(Consultant::class)->findAll();
        }
        else {
            $searchresult = $em->getRepository(Consultant::class)->findByUsername($search);
        }

        foreach ($searchresult as $datasearch)
        {
            $thisGender = $em->getRepository('AppBundle:datauser')->findOneByIduser($datasearch->getId());
            $tabsearch[] = array(
                'gender' => $thisGender->getGenre(),
                'username' => $datasearch->getUsername(),
                'lastlogin' => $datasearch->getLastlogin(),
                'id' => $datasearch->getId(),
            );
        }

        return $this->render('search.html.twig', array(
            'tabsearchs' => $tabsearch,
        ));
    }


}
