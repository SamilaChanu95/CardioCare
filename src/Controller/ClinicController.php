<?php

namespace App\Controller;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClinicController extends AbstractController
{
    /**
     * @Route("/clinic", name="clinics_list")
     */
    public function display()
    {
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('clinic/clinic.html.twig', [
            'patients' => $patients
        ]);
    }
}
