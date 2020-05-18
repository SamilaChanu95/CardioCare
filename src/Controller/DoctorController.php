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

class DoctorController extends AbstractController
{
    /**
     * @Route("/doctor", name="doctors_list")
     */
    public function display()
    {

        $doctors = $this->getDoctrine()->getRepository(Doctor::class)->findAll();
        
        return $this->render('doctor/doctor.html.twig', [
            'doctors' => $doctors,
        ]);
    }

    /**
     * @Route("/doctor/add", name="doctor_add")
     */
    public function createDoctor(Request $request): Response
    {
        $doctor = new Doctor();

        $form = $this->createForm(DoctorType::class, $doctor);
            
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

            return $this->redirectToRoute('doctors_list');
        }
        
        return $this->render('doctor/doctor_add.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/doctor/edit/{id}", name="doctor_edit")
     */
    public function edit(Request $request,$id)
    {
        $doctor = new Doctor();

        $doctor = $this->getDoctrine()->getRepository(Doctor::class)->find($id);

        $form = $this->createFormBuilder($doctor)
            ->add('dNIC', TextType::class, array('required' => true,'label' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'NIC of Doctor')))
            ->add('dFirstName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'First Name of Doctor')))
            ->add('dLastName', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Last Name of Doctor')))
            ->add('dAddress', TextareaType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Address of Doctor')))
            ->add('dGender', ChoiceType::class, array('choices' => [ 'Gender' => [ 'Male' => 'Male', 'Female' => 'Female']],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Gender')))
            ->add('dDOB', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Date of Birth')))
            ->add('dPhoneNumber', TextType::class, array('required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Phone Number')))
            ->add('dRole', ChoiceType::class, array('choices' => [ 'Main Doctor' =>  'Main Doctor', 'Assistant Doctor' => 'Assistant Doctor', 'Doctor Anaesthetist' => 'Doctor Anaesthetist'],'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Department', EntityType::class, array('class' => Department::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Unit', EntityType::class, array('class' => Unit::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('Ward', EntityType::class, array('class' => Ward::class, 'required' => true,'label' => false,'attr' => array('class' => 'form-control')))
            ->add('dStatus', ChoiceType::class, array('choices' => [ 'Active' => 'Active', 'Deactive' => 'Deactive'],'required' => true,'label' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Status')))
            ->add('photo', FileType::class, array('required' => false, 'mapped' => false, 'label' => false, 'constraints' => array(
                new File([
                    'maxSize' => '2048k',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                        'image/tiff',
                        'image/bmp',
                        'image/other',
                    ],
                    'mimeTypesMessage' => "Please upload photo less than 2MB.",   
                    ])
                ),
            ))
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'label' => 'Retype the characters from the picture',
                'constraints' => [
                    new ValidCaptcha ([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
            ->add('save', SubmitType::class, array('label'=> 'Update', 'attr' => array('class' => 'btn btn-primary mt-3')))
            ->getForm();

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

            return $this->redirectToRoute('doctors_list');
        }

        return $this->render('doctor/doctor_edit.html.twig', [
            'form' => $form->createView()
        ]);
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
            ->setParameter("departmentid", $request->query->get("department.id"))
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

}
