<?php

namespace App\DataFixtures;
use App\Entity\Role;
use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class MemberFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
            $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $fakerMemb = Factory::create('FR fr');

        $adminRole= new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminMember = new Member();
        $dateB = $fakerMemb->date();
        $birthDay = new DateTime($dateB);

        $adminMember->setFirstName('Bouchet')
                    ->setName('Pierre')
                    ->setPseudo('Pierrot')
                    ->setPassword($this->encoder->encodePassword($adminMember, 'password'))
                    ->setSex('Homme')
                    ->setNumLicense(123456789)
                    ->setPhone1("04-67-99-38-64")
                    ->setPhone2("06-07-01-53-11")
                    ->setAddress($fakerMemb->streetAddress)
                    ->setBirthdayDate($birthDay)
                    ->setCp(mt_rand(1100, 9000))
                    ->setCity($fakerMemb->city)
                    ->setLevelDive( "N3")
                    ->setBoatLicense(true)
                    ->setInstructor( "E1")
                    ->setMail('pf.bouchet@orange.fr')
                    ->addUsersRole($adminRole);
        $manager->persist($adminMember);

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
            $password = $this->encoder->encodePassword($member, 'password');


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
