<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $item = new Item();
        $item->setName("Pizza");
        $item->setPrice("14.99");
        $item->addProperty(new Property("vegan"));
        $item->addProperty(new Property("vegetarian"));
        $item->addProperty(new Property("glutenfree"));
        $item->addProperty(new Property("spicy"));
        $item->addProperty(new Property("sweet"));

        $manager->persist($item);

        $item = new Item();
        $item->setName("Hamburger");
        $item->setPrice("7.99");
        $item->addProperty(new Property("meaty"));
        $item->addProperty(new Property("greasy"));
        $item->addProperty(new Property("cheesy"));
        $item->addProperty(new Property("vegan"));

        $manager->persist($item);

		$item = new Item();
        $item->setName("French Fries");
        $item->setPrice("4.99");
        $item->addProperty(new Property("crispy"));
        $item->addProperty(new Property("crunchy"));
        $item->addProperty(new Property("salty"));

        $manager->persist($item);

        $manager->flush();
    }
}
