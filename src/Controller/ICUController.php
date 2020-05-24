<?php

namespace App\Controller;

use App\Entity\ICU;
use App\Form\ICUType;
use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
use Doctrine\ORM\EntityRepository;

/**
 * @Route("/icu")
 */
class ICUController extends AbstractController
{
    /**
     * @Route("/", name="icu_reports_list")
     */
    public function displayICU()
    {

        $icureports = $this->getDoctrine()->getRepository(ICU::class)->findAll();
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('icu/icureport.html.twig', [
            'icureports' => $icureports,
            'patients' => $patients
        ]);
    }


    /**
     * @Route("/add", name="icureport_add", methods={"GET","POST"})
     */
    public function createICUReport(Request $request)
    {
        $icureport = new ICU();
        $form = $this->createForm(ICUType::class, $icureport,['edit_mode' => false,]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($icureport);
            $entityManager->flush(); 

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/icureport_new.html.twig', [
            'icureport' => $icureport,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="icureport_show", methods={"GET"})
     */
    public function show(ICU $icureport): Response
    {
        return $this->render('icu/icureport_show.html.twig', [
            'icureport' => $icureport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="icureport_edit", methods={"GET","POST"})
     */
    public function editICUReport(Request $request,ICU $icureport)
    {
        $form = $this->createForm(ICUType::class, $icureport,['edit_mode' => true,]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('icu_reports_list');
        }

        return $this->render('icu/icureport_new.html.twig', [
            'icu' => $icureport,
            'form' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/{id}", name="icureport_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ICU $icureport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$icureport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($icureport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('icu_reports_list');
    }


}
