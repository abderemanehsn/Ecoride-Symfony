<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;


class ContactDTO
{

    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'le nom est obligatoire avec au minimum {Limit} caractères',
        maxMessage: 'Le nom depasse {{ Limit }} caractères'

    )]
    public string $name='';


    #[Assert\Email(

      message: 'Veuiller entrez une adresse mail valide'

    )]
     #[Assert\NotBlank(

      message: 'Veuiller entrez un mail '

    )]
    public string $email='';


    #[Assert\Length(
        min: 10,
        max: 1000,
        minMessage: 'le message est obligatoire avec au minimum {Limit} caractères',
    )]
    public string $message='';

}