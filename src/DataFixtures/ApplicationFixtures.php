<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Film;
use App\Entity\FilmStudio;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture
{
    private $faker;

    private $dateGanre = [
        'Action',
        'Adventure',
        'Animation',
        'Biography',
        'Comedy',
        'Crime'
    ];

    private $dateDescription = [];

    private $dateAddress = [];

    public function __construct()
    {
        // Can use facker populator but we use relation
        // $generator = \Faker\Factory::create();
        // $populator = new Faker\ORM\Propel\Populator($generator);

        $this->faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $this->dateAddress[] = $this->faker->address;
            $this->dateDescription[] = $this->faker->realText(500, 2);
        }
    }

    public function getRandomGanre(){
        return $this->dateGanre[rand(0, count($this->dateGanre) - 1)];
    }

    public function getRandomDescription(){
        return $this->dateDescription[rand(0, count($this->dateDescription) - 1)];
    }

    public function getRandomPhone(){
        return $this->faker->tollFreePhoneNumber;
    }

    public function getRandomAddress(){
        return $this->dateAddress[rand(0, count($this->dateAddress) - 1)];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $count = 15;
        $actors = $studios = $films = [];
        for ($s = 0; $s < $count; $s++) {
            $studio = new FilmStudio();
            $studio->setName($this->faker->company);
            $studio->setPhone($this->getRandomPhone());
            $studio->setAddress($this->getRandomAddress());
            $studio->setDateCreate(new \DateTime("now"));
            $studios[] = $studio;
            $manager->persist($studio);
        }

        for ($a = 0; $a < $count; $a++) {
            $actor = new Actor();
            $actor->setName($this->faker->name);
            $actor->setEmail($this->faker->email);
            $actor->setPhone($this->getRandomPhone());
            $actors[] = $actor;
            $manager->persist($actor);
        }

        for ($f = 0; $f < $count; $f++) {
            $film = new Film();
            $film->setName($this->faker->realText(rand(10, 20),2));
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