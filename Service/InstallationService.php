<?php

// src/Service/InstallationService.php
namespace CommonGateway\TemplateBundle\Service;

use App\Entity\DashboardCard;
use App\Entity\Endpoint;
use CommonGateway\CoreBundle\Installer\InstallerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallationService implements InstallerInterface
{
    private EntityManagerInterface $entityManager;
    private SymfonyStyle $io;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Set symfony style in order to output to the console
     *
     * @param SymfonyStyle $io
     * @return self
     */
    public function setStyle(SymfonyStyle $io): self
    {
        $this->io = $io;

        return $this;
    }

    public function install()
    {
        $this->checkDataConsistency();
    }

    public function update()
    {
        $this->checkDataConsistency();
    }

    public function uninstall()
    {
        // Do some cleanup
    }

    public function checkDataConsistency()
    {

        // Lets create some genneric dashboard cards
        // $objectsThatShouldHaveCards = ['https://common-gateway.nl/template-group.schema.json', 'https://common-gateway.nl/template.schema.json'];

        // foreach ($objectsThatShouldHaveCards as $object) {
        //     (isset($this->io) ? $this->io->writeln('Looking for a dashboard card for: ' . $object) : '');
        //     $entity = $this->entityManager->getRepository('App:Entity')->findOneBy(['reference' => $object]);
        //     if (
        //         $entity &&
        //         !$dashboardCard = $this->entityManager->getRepository('App:DashboardCard')->findOneBy(['entityId' => $entity->getId()])
        //     ) {
        //         $dashboardCard = new DashboardCard($entity);
        //         $this->entityManager->persist($dashboardCard);
        //         (isset($this->io) ? $this->io->writeln('Dashboard card created') : '');
        //         continue;
        //     }
        //     (isset($this->io) ? $this->io->writeln('Dashboard card found') : '');
        // }

        // Let create some endpoints
        // $objectsThatShouldHaveEndpoints = ['https://common-gateway.nl/template-group.schema.json', 'https://common-gateway.nl/template.schema.json'];

        // foreach ($objectsThatShouldHaveEndpoints as $object) {
        //     (isset($this->io) ? $this->io->writeln('Looking for a endpoint for: ' . $object) : '');
        //     $entity = $this->entityManager->getRepository('App:Entity')->findOneBy(['reference' => $object]);

        //     if (
        //         $entity &&
        //         count($entity->getEndpoints()) == 0
        //     ) {
        //         $endpoint = new Endpoint($entity);
        //         $this->entityManager->persist($endpoint);
        //         (isset($this->io) ? $this->io->writeln('Endpoint created') : '');
        //         continue;
        //     }
        //     (isset($this->io) ? $this->io->writeln('Endpoint found') : '');
        // }

        $schemaRepository = $this->entityManager->getRepository('App:Entity');
        $templateGroup = $schemaRepository->findOneBy(['name' => 'TemplateGroup']);

        $endpoint = $endpointRepository->findOneBy(['name' => 'TemplateGroups collection']) ?? new Endpoint();
        $endpoint->setName('TemplateGroups collection');
        $endpoint->setPathRegex('^(template_groups)$');
        $endpoint->setMethods(["POST", "GET"]);
        $endpoint->setMethod("POST");
        $endpoint->setEntity($templateGroup);
        $endpoint->setOperationType('collection');

        $this->entityManager->persist($endpoint);
        $endpoint = $endpointRepository->findOneBy(['name' => 'TemplateGroups item']) ?? new Endpoint();
        $endpoint->setName('TemplateGroups item');
        $endpoint->setPathRegex('^(template_groups/[a-z0-9-]{36})$');
        $endpoint->setMethods(["PUT", "GET"]);
        $endpoint->setMethod("POST");
        $endpoint->setEntity($templateGroup);
        $endpoint->setOperationType('item');
        $this->entityManager->persist($endpoint);


        $this->entityManager->flush();

        // Lets see if there is a generic search endpoint


    }
}
