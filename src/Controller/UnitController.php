<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Form\UnitType;
use App\Repository\UnitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include JSON Response
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/unit")
 */
class UnitController extends AbstractController
{
    /**
     * @Route("/", name="unit_index", methods={"GET"})
     */
    public function index(UnitRepository $unitRepository): Response
    {
        return $this->render('unit/unit.html.twig', [
            'units' => $unitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="unit_add", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $unit = new Unit();
        $form = $this->createForm(UnitType::class, $unit,['edit_mode' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($unit);
            $entityManager->flush();

            return $this->redirectToRoute('unit_index');
        }

        return $this->render('unit/new.html.twig', [
            'unit' => $unit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unit_show", methods={"GET"})
     */
    public function show(Unit $unit): Response
    {
        return $this->render('unit/show.html.twig', [
            'unit' => $unit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="unit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Unit $unit): Response
    {
        $form = $this->createForm(UnitType::class, $unit,['edit_mode' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unit_index');
        }

        return $this->render('unit/edit.html.twig', [
            'unit' => $unit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="unit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Unit $unit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$unit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($unit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('unit_index');
    }

    /**
    * @Route("/department", name="unit_getDepartment", methods={"GET","POST"})
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
}
