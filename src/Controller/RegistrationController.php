<?php

namespace App\Controller;

//use ReCaptcha\ReCaptcha;  // Include the recaptcha lib
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $plainPassword = $user -> getPlainPassword();
            $encoded = $encoder -> encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'You are now successfully registered!');

            return $this->redirectToRoute('home');
        }
        return $this->render('registration/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }

    /*
    public function mysubmitedAction(Request $request){
        
        $recaptcha = new ReCaptcha('6LfSiegUAAAAAP1UkT8qIRfI2afBD9z22zDlUuY2');
        $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
      
        if (!$resp->isSuccess()) {
          // Do something if the submit wasn't valid ! Use the message to show something
          $message = "The reCAPTCHA wasn't entered correctly. Go back and try it again." . "(reCAPTCHA said: " . $resp->error . ")";
        }else{
          // Everything works good ;) your contact has been saved.
        }
    }
    */

}
