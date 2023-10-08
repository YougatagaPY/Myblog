<?php

namespace App\DataFixtures;

use App\Entity\Article;
use app\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $liste = array('Film', 'Food', 'Games');
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setPseudo($faker->name());
            $user->setPassword($faker->password());
            $user->setMail($faker->email());
            $manager->persist($user);

            $article = new Article();
            $article->setTitre($faker->title());
            $article->setContenu($faker->text());
            $article->setDate($faker->dateTime());
            $manager->persist($article);
        }

        $manager->flush();

    }
}
