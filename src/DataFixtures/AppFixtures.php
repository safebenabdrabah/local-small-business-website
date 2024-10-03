<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Profile;
use App\Entity\SmallBusiness;
use App\Entity\User;
use EsperoSoft\Faker\Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();
        $smallbusinesses=[];
      
        for ($i=0; $i <6 ; $i++) { 
        
            $profile=(new Profile()) ->setFullName($faker->full_name())
                                     ->setProfilePic($faker->image());

            $category=(new Category())->setCategoryName($faker->name());

            $user=(new User()) ->setEmail($faker->email())
                                ->setPassword('admin')
                                ->setUsername($faker->name())
                                ->setRoles(['ROLE_USER'])
                                ->setProfile($profile);
            $manager->persist($user);
            $manager->persist($category);
            for ($j=0; $j <10 ; $j++) { 
                $smallbusiness = (new SmallBusiness()) ->setName($faker->name())
                                                       ->setLogo($faker->image())
                                                       ->setDescription($faker->text())
                                                       ->setPhoneNumber( $faker->phone())                                                               ->setAddress( $faker->streetAddress())
                                                       ->setFacebookPage($faker->name())
                                                       ->setInstagramPage($faker->name());
                                
            
                                                     
            $smallbusiness->addCategory($category);
            $profile->addSmallBusiness($smallbusiness);
            $manager->persist($profile);
            $manager->persist($smallbusiness);
                            
        }
    }
        // $manager->persist($product);

        $manager->flush();
    }
}
