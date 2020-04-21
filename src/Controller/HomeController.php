<?php

namespace App\Controller;

use App\Entity\Doctor;
use App\Entity\Nurse;
use App\Entity\Technician;
use App\Entity\Consultant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $doctors = $this->getDoctrine()->getRepository(Doctor::class)->findAll();
        $nurses = $this->getDoctrine()->getRepository(Nurse::class)->findAll();
        $consultants = $this->getDoctrine()->getRepository(Consultant::class)->findAll();
        $technicians = $this->getDoctrine()->getRepository(Technician::class)->findAll();

        return $this->render('home/home.html.twig', [
            'doctors' => $doctors,
            'nurses' => $nurses,
            'technicians' => $technicians,
            'consultants' => $consultants,
        ]);
    }
}
