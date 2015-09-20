<?php

namespace App\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class AppFixtures extends DataFixtureLoader
{
    public function load(ObjectManager $manager)
    {
        $manager = $this->container->get('app_core.object_manager.ogm');

        return parent::load($manager);
    }

    protected function getFixtures()
    {
        return  [__DIR__ . '/persons.yml'];
    }
}
