<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create("ro_RO");

        //Handle Roles
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        //Handle admin account
        $admin = new User();
        $admin->setFirstName('Jeremy')
            ->setLastName('Admin')
            ->setIntroduction("Hey! I'm the founder of this cool website")
            ->setDescription("This is a nice description, isn't it?")
            ->setEmail('admin@uniswap.ro')
            ->setHash($this->encoder->hashPassword($admin,'password'))
            ->addRole($adminRole);
        $manager->persist($admin);

        //Handle users
        $users = [];
        $genres = ['male', 'female'];
        for($i = 1; $i <= 50; $i++) {
            $user = new User();
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
            $hash = $this->encoder->hashPassword($user, 'password');
            $user->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
                ->setPicture($picture);
            $manager->persist($user);
            $users[] = $user;
        }

        //Handle categories
        $categories = [];
        for($i = 0; $i < 5; $i++){
            $category = new Category();
            $category->setName($faker->word)
                ->setColor($faker->hexColor);
            $manager->persist($category);
            $categories[] = $category;
        }

        //Handle ads
        for($i = 0; $i < 20; $i++) {
            $ad = new Ad();
            $ad->setTitle($faker->sentence)
                //     ->setIntroduction($faker->paragraph(2))
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setThumbnail("https://picsum.photos/210/118?random=" . mt_rand(1, 55000))
                ->setPublishedDate($faker->dateTimeBetween('-12 months'))
                ->setAuthor($users[mt_rand(0, count($users) - 1)])
                ->addCategory($categories[mt_rand(0, count($categories) -1)]);
            $manager->persist($ad);
        }

        $manager->flush();
    }
}
