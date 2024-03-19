<?php
// src\DataFixtures\AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Ressource;
use App\Entity\RessourceType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail("user@bookapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        $names = ['video', 'photo', 'article', 'jeux'];
        $listTypes = [];
        for ($i = 0; $i < 5; $i++) {
            // Création de l'auteur lui-même.
            $type = new RessourceType();
            $name = array_rand($names);
            $type->setSlug(strtoupper($name));
            $type->setTitle(strtolower($name));
            $manager->persist($type);
            $listTypes[] = $type;
        }
        // Création d'une vingtaine de livres ayant pour titre
        for ($i = 0; $i < 20; $i++) {
            $ressource = new Ressource();
            $ressource->setTitle('Livre ' . $i);
            $ressource->setDescription('Quatrième de couverture numéro : ' . $i);
            $ressource->setRessourceType($listTypes[array_rand($listTypes)]);
            $ressource->setUser($userAdmin);
            $manager->persist($ressource);
        }

        $manager->flush();
    }
}