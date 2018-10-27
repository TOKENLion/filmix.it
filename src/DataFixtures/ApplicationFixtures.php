<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Film;
use App\Entity\FilmStudio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture
{
    private $dateGanre = [
        'Action',
        'Adventure',
        'Animation',
        'Biography',
        'Comedy',
        'Crime'
    ];

    private $dateDescription = [
        'Lorem ipsum dolor sit amet, an pro essent delenit, altera atomorum vix ne. 
        Cum congue iudico verear ad, vel utamur posidonium no. Cu quo natum dicunt, 
        expetenda deseruisse cu quo. Ut duo soluta epicurei ocurreret, ea usu ferri 
        tollit feugiat, ei pro torquatos posidonium eloquentiam. Causae malorum nam 
        cu, amet dignissim his ne, utinam everti te sed.',
        'Ei has mutat delenit eloquentiam, quo magna euismod an, oblique vituperatoribus 
        an pri. Eu urbanitas voluptaria scripserit qui, qui deleniti quaestio cu. Eos in 
        partiendo aliquando. Ex vim dicta cotidieque dissentiunt. Eu dico dolore 
        petentium ius, sed quot volutpat te.',
        'Ex iisque eloquentiam sea, vide dicant utinam ut nam. An eos viderer nusquam. 
        Volumus scaevola ocurreret cum eu, nam an erat justo. Ut tale meis quo, te 
        quod tibique euripidis eum. Cum ut velit possim adversarium.'
    ];

    private $dateAddress = [
        '9 Pawnee Dr. Saint Charles, IL 60174',
        '9422 4th Street Greenville, NC 27834',
        '217 Fulton Rd. Voorhees, NJ 08043',
        '94 Highland Ave. The Villages, FL 32162',
        '7939 W. Rocky River Drive Mahwah, NJ 07430',
        '619 Euclid Drive Waterford, MI 48329'
    ];

    public function getRandomGanre(){
        return $this->dateGanre[rand(0, count($this->dateGanre) - 1)];
    }

    public function getRandomDescription(){
        return $this->dateDescription[rand(0, count($this->dateDescription) - 1)];
    }

    public function getRandomPhone(){
        return rand(1111111111, 9999999999);
    }

    public function getRandomAddress(){
        return $this->dateAddress[rand(0, count($this->dateAddress) - 1)];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $count = 10;
        $actors = $studios = $films = [];
        for ($s = 0; $s < $count; $s++) {
            $studio = new FilmStudio();
            $studio->setName("Studio Name_{$s}");
            $studio->setPhone($this->getRandomPhone());
            $studio->setAddress($this->getRandomAddress());
            $studio->setDateCreate(new \DateTime("now"));
            $studios[] = $studio;
            $manager->persist($studio);
        }

        for ($a = 0; $a < $count; $a++) {
            $actor = new Actor();
            $actor->setName("Name Actor{$a}");
            $actor->setEmail("user{$a}.actor@email.com");
            $actor->setPhone($this->getRandomPhone());
            $actors[] = $actor;
            $manager->persist($actor);
        }

        for ($f = 0; $f < $count; $f++) {
            $film = new Film();
            $film->setName("Film {$f}");
            $film->setGenre($this->getRandomGanre());
            $film->setDescription($this->getRandomDescription());
            $film->setDateCreate(new \DateTime("now"));
            $film->setStudio($studios[rand(0, $count - 1)]);

            for ($i = 1; $i <= intval($count / 3); $i++) {
                switch ($i) {
                    case 0: $rand = rand(0, 2); break;
                    case 1: $rand = rand(3, 5); break;
                    case 2: $rand = rand(6, 9); break;
                    default:$rand = rand(0, $count - 1);
                }
                $film->addActor($actors[$rand]);
            }
            $manager->persist($film);
        }

        $manager->flush();
    }


}