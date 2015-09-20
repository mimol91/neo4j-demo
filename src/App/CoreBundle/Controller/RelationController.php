<?php

namespace App\CoreBundle\Controller;

use App\CoreBundle\Entity\Person;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RelationController extends Controller
{
    /**
     * @Template()
     */
    public function selectRelatedPersonAction()
    {
        $form = $this->createForm('related');

        return ['form' => $form->createView()];
    }

    /**
     * @Template("@Core/Relation/showRelation.html.twig")
     */
    public function showRelationAction(Request $request)
    {
        $personRepo = $this->get('neo4j.manager')->getRepository(Person::class);
        $form = $this->createForm('related');
        $form->handleRequest($request);

        $personFrom = $personRepo->find($form->get('personFrom')->getData());
        $personTo = $personRepo->find($form->get('personTo')->getData());

        try {
            if ($form->get('orm')->isClicked()) {
                $personRelationModel = $this->getRelationViaOrm($personFrom, $personTo);
            } else {
                $personRelationModel = $this->getRelationViaOgm($personFrom, $personTo);
            }
        } catch (Exception $e) {
            return new Response($e->getMessage());
        }

        return ['relationModel' => $personRelationModel];
    }

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return array
     */
    private function getRelationViaOrm(Person $personFrom, Person $personTo)
    {
        $friendRelationFetcher = $this->get('app_core.services_friend_relation.sqlrelation');

        return $personRelationModel = $friendRelationFetcher->getRelationPath($personFrom, $personTo);
    }

    /**
     * @param Person $personFrom
     * @param Person $personTo
     *
     * @return array
     *
     * @throws Exception
     */
    private function getRelationViaOgm(Person $personFrom, Person $personTo)
    {
        $em = $this->container->get('neo4j.manager');

        $result = $em->createCypherQuery()
            ->match(sprintf('p=shortestPath((a:Person {fullName:\'%s\'})-[*]-(b:Person {fullName:\'%s\'}))', $personFrom->getFullName(), $personTo->getFullName()))
            ->end('p')
            ->getList()
            ->first();

        if (!$result) {
            throw new \Exception('Relation does not exist');
        }

        return $result->getEntities();
    }
}
