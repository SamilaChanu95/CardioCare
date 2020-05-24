<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use App\Repository\DoctorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Mime\MimeTypes;
use App\Form\DoctorType;
use Symfony\Component\Validator\Constraints\File;

/**
* @Route("/doctor")
*/
class DoctorController extends AbstractController
{
    /**
     * @Route("/", name="doctor_index", methods={"GET"})
     */
    public function index(DoctorRepository $doctorRepository): Response
    {
        return $this->render('doctor/doctor.html.twig', [
            'doctors' => $doctorRepository->findAll(),
        ]);
    } 

    /**
     * @Route("/add", name="doctor_add", methods={"GET","POST"})
     */
    public function createDoctor(Request $request): Response
    {
        $doctor = new Doctor();
        $form = $this->createForm(DoctorType::class, $doctor,['edit_mode' => false,]);
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

                $doctor->setPhoto($fileName);
            }
     
            //echo "<pre>";
            //var_dump($file); die;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctor);
            $entityManager->flush(); 

            return $this->redirectToRoute('doctor_index');
        }
        
        return $this->render('doctor/new.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/{id}", name="doctor_show", methods={"GET"})
     */
    public function show(Doctor $doctor): Response
    {
        return $this->render('doctor/show.html.twig', [
            'doctor' => $doctor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="doctor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Doctor $doctor): Response
    {
        $form = $this->createForm(DoctorType::class, $doctor,['edit_mode' => true,]);
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

                $doctor->setPhoto($fileName);
            } 
                  
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('doctor_index');
        }

        return $this->render('doctor/edit.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="doctor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Doctor $doctor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$doctor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($doctor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('doctor_index');
    }


    /**
     * Returns a JSON string with the units of the Department with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function listUnitsOfDepartmentAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $unitsRepository = $em->getRepository(Unit::class);
        
        // Search the units that belongs to the department with the given id as GET parameter "departmentid"
        $units = $this->$unitsRepository->createQueryBuilder("q")
            ->where("q.Department = :departmentid")
            ->setParameter("departmentid", $request->query->get("departmentid"))
            ->getQuery()
            ->getResult();
        
        // Serialize into an array the data that we need, in this case only name and id
        // Note: you can use a serializer as well, for explanation purposes, we'll do it manually
        $responseArray = array();
        foreach($units as $unit){
            $responseArray[] = array(
                "id" => $unit->getId(),
                "name" => $unit->getUnitName()
            );
        }
        
        // Return array with structure of the units of the providen department id
        return new JsonResponse($responseArray);

        // e.g
        // [{"id":"3","name":"Treasure Island"},{"id":"4","name":"Presidio of San Francisco"}]
    }

    /**
    * @Route("/department", name="doctor_getDepartment", methods={"GET","POST"})
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
    * @Route("/unit", name="doctor_getUnit", methods={"GET","POST"})
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
    * @Route("/ward", name="doctor_getWard", methods={"GET","POST"})
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
