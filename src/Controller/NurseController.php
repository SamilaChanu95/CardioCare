<?php

namespace App\Controller;

use App\Form\NurseType;
use App\Entity\Department;
use App\Entity\Unit;
use App\Entity\Ward;
use App\Entity\Nurse;
use App\Repository\NurseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("/nurse")
*/
class NurseController extends AbstractController
{
    /**
     * @Route("/", name="nurse_index", methods={"GET"})
     */
    public function index(NurseRepository $nurseRepository): Response
    {
        return $this->render('nurse/nurse.html.twig', [
            'nurses' => $nurseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="nurse_add", methods={"GET","POST"})
     */
    public function createNurse(Request $request):Response
    {
        $nurse = new Nurse();
        $form = $this->createForm(NurseType::class, $nurse,['edit_mode' => false,]);
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
                
                $nurse->setPhoto($fileName); 
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nurse);
            $entityManager->flush(); 

            return $this->redirectToRoute('nurse_index');
        }

        return $this->render('nurse/new.html.twig',array(
            'nurse' => $nurse,
            'form' => $form->createView()
        ));    
    }

    /**
     * @Route("/{id}", name="nurse_show", methods={"GET"})
     */
    public function show(Nurse $nurse): Response
    {
        return $this->render('nurse/show.html.twig', [
            'nurse' => $nurse,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nurse_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nurse $nurse): Response
    {
        $form = $this->createForm(NurseType::class, $nurse,['edit_mode' => true,]);
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
                
                $nurse->setPhoto($fileName); 
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('nurse_index');
        }
        
        return $this->render('nurse/edit.html.twig', [
            'nurse' => $nurse,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nurse_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nurse $nurse): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nurse->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nurse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nurse_index');
    }

    /**
    * @Route("/department", name="nurse_getDepartment", methods={"GET","POST"})
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
    * @Route("/unit", name="nurse_getUnit", methods={"GET","POST"})
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
    * @Route("/ward", name="nurse_getWard", methods={"GET","POST"})
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
