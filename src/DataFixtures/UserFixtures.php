<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{


    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $usersArray = [
                        [
                            "email" => "oceanebarb@hotmail.com",
                            "username" => "oceba",
                            "password" => "Ocean84-Barb",
                        ],
                        [
                            "email" => "milanj@yahoo.fr",
                            "username" => "milanju",
                            "password" => "Mila42+Jul",
                        ],
                        [
                            "email" => "xavdu@hotmail.com",
                            "username" => "xadupo",
                            "password" => "Xavier75+Dupon",
                        ],
                        [
                            "email" => "lucydupuy@yahoo.fr",
                            "username" => "lucdupu",
                            "password" => "Luc156-Dup",
                        ],
                        [
                            "email" => "rgil@yahoo.fr",
                            "username" => "roseg",
                            "password" => "Ros88-Gill",
                        ],
                        [
                            "email" => "alexmar@yahoo.fr",
                            "username" => "alexmari",
                            "password" => "Alexi77!Mar",
                        ],
                        [
                            "email" => "emirivier@yahoo.com",
                            "username" => "emilrivier",
                            "password" => "emi123!Rivier",
                        ],
                        [
                            "email" => "florencbourgeo@yahoo.com",
                            "username" => "flob",
                            "password" => "Floren7>Bourgeo",
                        ],
                        [
                            "email" => "apoir@yahoo.fr",
                            "username" => "alipoi",
                            "password" => "Aliya106<Poi",
                        ],
                        [
                            "email" => "romylemo@hotmail.com",
                            "username" => "romle",
                            "password" => "Rom8>Lemoin",
                        ],
                        [
                            "email" => "roseco@hotmail.fr",
                            "username" => "roco",
                            "password" => "Ros13<Colin",
                        ],
                        [
                            "email" => "victdeschamp@hotmail.com",
                            "username" => "vd",
                            "password" => "Vic19>Deschamp",
                        ],
                        [
                            "email" => "huben@gmail.com",
                            "username" => "hubben",
                            "password" => "Huber43@Benoit",
                        ],
                        [
                            "email" => "rosafranc@yahoo.fr",
                            "username" => "rosaliefranc",
                            "password" => "Rosali84?Fran",
                        ],
                        [
                            "email" => "leonihube@yahoo.fr",
                            "username" => "leonihub",
                            "password" => "Leo6+Hub",
                        ],
                        [
                            "email" => "ryafle@hotmail.fr",
                            "username" => "ryanfleu",
                            "password" => "Rya81!Fleury",
                        ],
                        [
                            "email" => "edouj@yahoo.com",
                            "username" => "edjacq",
                            "password" => "edouar133!Jacquet",
                        ],
                        [
                            "email" => "rmi@hotmail.fr",
                            "username" => "ryamichel",
                            "password" => "Ryan77!Mich",
                        ],
                        [
                            "email" => "livfle@gmail.com",
                            "username" => "livifle",
                            "password" => "Livia35?Fleu",
                        ],
                        [
                            "email" => "efournier@gmail.com",
                            "username" => "etf",
                            "password" => "Eth83?Fourni",
                        ],
                        [
                            "email" => "chroye@hotmail.fr",
                            "username" => "charleroyer",
                            "password" => "Char1@Roy",
                        ],
                        [
                            "email" => "libarr@hotmail.com",
                            "username" => "lilliaba",
                            "password" => "Lill137>Bar",
                        ],
                        [
                            "email" => "dagera@yahoo.fr",
                            "username" => "dagerar",
                            "password" => "Davi61@Gerar",
                        ],
                        [
                            "email" => "charloduran@yahoo.com",
                            "username" => "charld",
                            "password" => "Charlo15<Dur",
                        ],
                        [
                            "email" => "nicoladub@hotmail.com",
                            "username" => "nicduboi",
                            "password" => "Nicola46!Dubois",
                        ],
                        [
                            "email" => "juligauthier@gmail.com",
                            "username" => "jugauthie",
                            "password" => "Julia154@Gauthier",
                        ],
                        [
                            "email" => "sarahd@yahoo.com",
                            "username" => "sarahd",
                            "password" => "Sarah153?Dumont",
                        ],
                        [
                            "email" => "annalefe@hotmail.com",
                            "username" => "annlefev",
                            "password" => "Anna107<Lefev",
                        ],
                    ];

        for ($element = 0 ; $element < 28; $element++) {
            $user = new User();
            $user->setUsername($usersArray[$element]['username']);
            $user->setEmail($usersArray[$element]['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $usersArray[$element]['password']));
            if (rand(0, 6) === 0) {
                $user->setRoles(['ROLE_ADMIN']);
            }

            $this->addReference("user-".$element, $user);
            $manager->persist($user);
        }

        $anonymous = new User();
        $anonymous->setUsername('anonymous');
        $anonymous->setEmail('nomail@fake.com');
        $anonymous->setPassword($this->passwordHasher->hashPassword($anonymous, 'password'));
        $this->addReference("anonymous", $anonymous);
        $manager->persist($anonymous);

        $manager->flush();
    }
}
