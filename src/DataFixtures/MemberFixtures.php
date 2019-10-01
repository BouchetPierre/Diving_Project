<?php

namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use Faker\Factory;


class MemberFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fakerMemb = Factory::create('FR fr');

        for ($i = 1; $i <= 20; $i++){

            $member = new Member();

            $dateB = $fakerMemb->date();
            $name = $fakerMemb->lastName;
            $fisrtN = $fakerMemb->firstName;
            $address = $fakerMemb->streetAddress;
            $city = $fakerMemb->city;
            $mail = $fakerMemb->email;
            $userN = $fakerMemb->firstName;
            $sex = rand(0, 1) ? 'Homme' : 'Femme';
            $password = $fakerMemb->password;


            $birthDay = new DateTime($dateB);
            $member->setName($name)
                   ->setFirstName($fisrtN)
                   ->setPseudo($userN)
                   ->setPassword($password)
                   ->setAddress($address)
                   ->setBirthdayDate($birthDay)
                   ->setCp(mt_rand(1100, 9000))
                   ->setCity($city)
                   ->setLevelDive( "N2")
                   ->setBoatLicense(true)
                   ->setInstructor( "E1")
                   ->setMail($mail)
                   ->setNumLicense(123456789)
                   ->setPhone1("04-67-99-38-64")
                   ->setPhone2("06-07-01-53-11")
                   ->setSex($sex);

            $manager->persist($member);
        }
        $manager->flush();
    }
}
