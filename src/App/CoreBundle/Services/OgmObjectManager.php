<?php

namespace App\CoreBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use HireVoice\Neo4j\EntityManager;

class OgmObjectManager implements ObjectManager
{
    /** @var EntityManager  */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function find($className, $id)
    {
        return $this->entityManager->find($className, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($object)
    {
        $this->entityManager->persist($object);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($object)
    {
        $this->entityManager->remove($object);
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository($className)
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * {@inheritdoc}
     */
    public function clear($objectName = null)
    {
        $this->entityManager->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function merge($object)
    {
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function detach($object)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($object)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getClassMetadata($className)
    {
        return new ClassMetadata($className);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadataFactory()
    {
        return new ClassMetadataFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function initializeObject($obj)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function contains($object)
    {
        return true;
    }
}
