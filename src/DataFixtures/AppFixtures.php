<?php
// src\DataFixtures\AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Comment;
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
        $user->setEmail("user@api.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setEmail("admin@api.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);

        $modo = new User();
        $modo->setEmail("modo@api.com");
        $modo->setRoles(["ROLE_MODO"]);
        $modo->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($modo);

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
        $ressources = [];
        for ($i = 0; $i < 50; $i++) {
            $ressource = new Ressource();
            $ressource->setTitle('Ressource ' . $i);
            $ressource->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum condimentum convallis tempor. Donec sodales, enim et pharetra semper, ex eros laoreet lorem, in venenatis nibh sem et odio. Pellentesque suscipit tristique odio quis iaculis. Etiam tincidunt arcu vel justo pellentesque maximus. Aenean urna erat, blandit sed auctor vel, porttitor quis ante. Nulla non neque dui. Fusce vestibulum tortor metus, eget finibus augue ultrices quis. Sed ultricies lorem ornare, ornare massa in,');
            $ressource->setRessourceType($listTypes[array_rand($listTypes)]);
            $ressource->setUser($userAdmin);
            $manager->persist($ressource);
            $ressources[] = $ressource;
        }

        for ($i = 0; $i < 50; $i++) {
            $comment = new Comment();
            $comment->setAccepted(array_rand([true, false]));
            $comment->setContent('et, consectetur adipiscing elit. Vestibulum condimentum convallis');
            $comment->setCreatedAt(new \DateTime());
            $comment->setRessource($ressources[array_rand($ressources)]);
            $comment->setUser($user);
            $manager->persist($comment);
        }

        $manager->flush();
    }
}