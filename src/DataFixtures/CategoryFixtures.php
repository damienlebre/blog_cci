<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i < 15; $i++){
            $category = new Category();            
            $category->setName("Category n° $i")            
            ->setSlug("category-$i");            

            $manager->persist($category);
            $this->addReference("cat" .$i, $category);
        }
        $this->addReference("cat" .$i, $category);
        $manager->flush();
    }
}
