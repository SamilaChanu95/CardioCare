<?php

namespace App\Controller;

use App\Entity\Technician;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Form\TechnicianType;
use App\Repository\TechnicianRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("/technician")
*/
class TechnicianController extends AbstractController
{
    /**
     * @Route("/", name="technician_index", methods={"GET"})
     */
    public function index(TechnicianRepository $technicianRepository): Response
    {
        $technicians = $this->getDoctrine()->getRepository(Technician::class)->findAll();
        return $this->render('technician/technician.html.twig', [
            'technicians' => $technicians,
        ]);
    }

    /**
     * @Route("/add", name="technician_add", methods={"GET","POST"})
     */

    public function createTechnician(Request $request):Response
    {
        $technician = new Technician();
        $form = $this->createForm(TechnicianType::class, $technician,['edit_mode' => false,]);        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            dump($technician);
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
                
                $technician->setPhoto($fileName); 
            } 
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technician);
            $entityManager->flush(); 

            return $this->redirectToRoute('technician_index');
        }

        return $this->render('technician/new.html.twig',array(
            'technician' => $technician,
            'form' => $form->createView()
        ));    
    }


    /**
     * @Route("/{id}", name="technician_show", methods={"GET"})
     */
    public function show(Technician $technician): Response
    {
        return $this->render('technician/show.html.twig', [
            'technician' => $technician,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="technician_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Technician $technician): Response
    {
        $form = $this->createForm(TechnicianType::class, $technician,['edit_mode' => true,]);    
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
                
                $technician->setPhoto($fileName); 
            }
             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('technician_index');
        }

        return $this->render('technician/edit.html.twig', [
            'technician' => $technician,
            'form' => $form->createView(),
        ]);    
    }

    /**
     * @Route("/{id}", name="technician_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Technician $technician): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technician->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($technician);
            $entityManager->flush();
        }

        return $this->redirectToRoute('technician_index');
    }

    /**
    * @Route("/department", name="technician_getDepartment", methods={"GET","POST"})
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
    * @Route("/unit", name="technician_getUnit", methods={"GET","POST"})
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
    * @Route("/ward", name="technician_getWard", methods={"GET","POST"})
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






