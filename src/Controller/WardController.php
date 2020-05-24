<?php

namespace App\Controller;

use App\Entity\Ward;
use App\Form\WardType;
use App\Repository\WardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include JSON Response
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/ward")
 */
class WardController extends AbstractController
{
    /**
     * @Route("/", name="ward_index", methods={"GET"})
     */
    public function index(WardRepository $wardRepository): Response
    {
        return $this->render('ward/ward.html.twig', [
            'wards' => $wardRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="ward_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ward = new Ward();
        $form = $this->createForm(WardType::class, $ward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ward);
            $entityManager->flush();

            return $this->redirectToRoute('ward_index');
        }

        return $this->render('ward/new.html.twig', [
            'ward' => $ward,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ward_show", methods={"GET"})
     */
    public function show(Ward $ward): Response
    {
        return $this->render('ward/show.html.twig', [
            'ward' => $ward,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ward_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ward $ward): Response
    {
        $form = $this->createForm(WardType::class, $ward);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ward_index');
        }

        return $this->render('ward/edit.html.twig', [
            'ward' => $ward,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ward_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ward $ward): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ward->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ward);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ward_index');
    }

    /**
    * @Route("/department", name="ward_getDepartment", methods={"GET","POST"})
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
    * @Route("/unit", name="ward_getUnit", methods={"GET","POST"})
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
}
