<?php

namespace App\Controller;

use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DischargeController extends AbstractController
{
    /**
     * @Route("/discharge", name="discharge")
     */
    public function index()
    {
        $patients = $this->getDoctrine()->getRepository(Patient::class)->findAll();

        return $this->render('discharge/discharge.html.twig', [
            'patients' => $patients
        ]);

    }
}
