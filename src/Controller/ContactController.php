<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $email = (new Email())
            ->from('estelam2007@gmail.com')
            ->to('estelam2007@gmail.com')
            ->subject('Contact')
            //->text('Sending emails is fun again!')
            ->html('<p>'.$form->getData()['name'].'</p>'.
                    
                        '<p>'.$form->getData()['email'].'</p>'.
                    
                        '<p>'.$form->getData()['text'].'</p>'
                    
                    
                    );

            $mailer->send($email);
            
        }
        
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController', 'form' => $form->createView(),
        ]);
    }
}
