<?php

namespace App\DataFixtures;

use App\Entity\Techno;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TechnoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //$html_css = new Techno();
        //$html_css->setNom('HTML / CSS');
        //$manager->persist($html_css);

        //$javascript = new Techno();
        //$javascript->setNom('Javascript');
        //$manager->persist($javascript);

        //$jquery = new Techno();
        //$jquery->setNom('JQuery');
        //$manager->persist($jquery);

        //$node = new Techno();
        //$node->setNom('JQuery');
        //$manager->persist($jquery);

        //$php = new Techno();
        //$php->setNom('PHP');
        //$manager->persist($php);

        $manager->flush();
    }
}
