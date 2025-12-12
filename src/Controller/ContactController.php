<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact( MailerInterface $mailer, Request $request): Response
    {

        

       $contact = new ContactDTO();

       // Pré-remplir le formulaire si l'utilisateur est connécté

        if($user = $this-> getUser()) {
            $contact-> name = $user->getPseudo();
            $contact-> email = $user->getEmail();
        }

       $form = $this->createForm(ContactType::class, $contact);

        $form-> handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {

            try {

              $data = $form->getData();

              $email = (new TemplatedEmail())
              ->from(new Address($data->email, $data->name))
              ->to('Ecoride@formation.studi')
              ->bcc('huguette@laposte.net')
              ->subject('Contact depuis le site Ecoride')
              ->text($data->message)
              ->htmlTemplate('emails/contact.html.twig')
              ->locale('fr')
              ->context([
                'message' => $data-> message
              ]);

              $mailer->send($email);

              $this->addflash('success', 'Votre message a bien envoyé !');

              return $this-> redirectToRoute('app_home');

            } catch (\Exception $e) {
              
              $this-> addflash('alert', 'Un probleme technique est survenu lors de l\'envoie');

            } 

            
          }

        

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form
        ]);
    }
}
