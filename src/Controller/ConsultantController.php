<?php

namespace App\Controller;

use App\Form\ConsultantType;
use App\Entity\Consultant;
use App\Repository\ConsultantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/consultant")
 */
class ConsultantController extends AbstractController
{

    /**
     * @Route("/", name="consultant_index", methods={"GET"})
     */
    public function index(ConsultantRepository $consultantRepository): Response
    {
        return $this->render('consultant/consultant.html.twig', [
            'consultants' => $consultantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="consultant_add", methods={"GET","POST"})
     */
    public function createConsultant(Request $request):Response
    {
        $consultant = new Consultant();
        $form = $this->createForm(ConsultantType::class, $consultant,['edit_mode' => false,]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('photo')->getData();

            if($file)
            {
                $photos_directory = $this->getParameter('photos_directory');
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                try {
                    $file->move(
                        $photos_directory, 
                        $fileName
                    );
                } catch (FileException $e) {
    
                }
                
                $consultant->setPhoto($fileName); 
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($consultant);
            $entityManager->flush(); 

            return $this->redirectToRoute('consultant_index');  
        }

        return $this->render('consultant/new.html.twig', [
            'consultant' => $consultant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultant_show", methods={"GET"})
     */
    public function show(Consultant $consultant): Response
    {
        return $this->render('consultant/show.html.twig', [
            'consultant' => $consultant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Consultant $consultant): Response
    {
        $form = $this->createForm(ConsultantType::class, $consultant,['edit_mode' => true,]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {  
            $file = $form->get('photo')->getData();

            if($file)
            {
                $photos_directory = $this->getParameter('photos_directory');
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                try {
                    $file->move(
                        $photos_directory, 
                        $fileName
                    );
                } catch (FileException $e) {
    
                }
                
                $consultant->setPhoto($fileName); 
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('consultant_index');
        }
        return $this->render('consultant/edit.html.twig', [
            'consultant' => $consultant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Consultant $consultant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($consultant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('consultant_index');
    }

    /*
    public function searchBarAction()
    {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->add('save', SubmitType::class, array('label'=> 'Search', 'attr' => array('class' => 'btn btn-danger mt-3')))
            ->getForm();

        return $this->render('consultant/consultant_search.html.twig', [
            'form' => $form->createView(),
        ]);    
        
    }
    */

    /**
     * @Route("/search", name="ajax_search")
     */
    public function search(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $consultants = $entityManager->getRepository(Consultant::class)->findEntitiesByString($requestString);
        if(!$consultants)
        {
            $result['consultants']['error'] = "Consultant not found";
            //var_dump("hello");
        }
        else
        {
            //check
            $result['consultants'] = $this->getRealEntities($consultants);

        } 
        //check 
        return new Response(json_encode($result));
    }

    public function getRealEntities($consultants)
    {
        foreach($consultants as $consultants)
        {
            $realEntities[$consultants->getId()] = [$consultants->getCFirstName()];
        }
        return $realEntities;
    }


    /**
    * @Route("/department", name="consultant_getDepartment", methods={"GET","POST"})
    */
    public function getDepartment(Request $request)
    {
        $id=$request->get("id");
        dump($id);
        // Get Entity manager and repository
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('App\Entity\Hospital');
        $hospital = $repository->findOneById($id);
        dump($hospital);
 
        $departments = $hospital->getDepartments();
        
        $responseArray = array();
        foreach($departments as $department){
            $responseArray[] = array(
                "id" => $department->getId(),
                "name" => $department->getDepartmentName()
            );
        }
      
        return new JsonResponse($responseArray);
    }

    
    /**
    * @Route("/unit", name="consultant_getUnit", methods={"GET","POST"})
    */
    
    public function getUnit(Request $request)
    {
        $id=$request->get("id");
        dump($id);
        // Get Entity manager and repository
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('App\Entity\Department');
        $department = $repository->findOneById($id);
        dump($department);
 
        $units = $department->getUnits();
        
        $responseArray = array();
        foreach($units as $unit){
            $responseArray[] = array(
                "id" => $unit->getId(),
                "name" => $unit->getUnitName()
            );
        }
      
        return new JsonResponse($responseArray);
    }

    /**
    * @Route("/ward", name="consultant_getWard", methods={"GET","POST"})
    */
    
    public function getWard(Request $request)
    {
        $id=$request->get("id");
        dump($id);
        // Get Entity manager and repository
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository('App\Entity\Unit');
        $unit = $repository->findOneById($id);
        dump($unit);
 
        $wards = $unit->getWards();
        
        $responseArray = array();
        foreach($wards as $ward){
            $responseArray[] = array(
                "id" => $ward->getId(),
                "name" => $ward->getWardName()
            );
        }
      
        return new JsonResponse($responseArray);
    }


}



