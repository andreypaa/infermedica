<?php

namespace App\Command;

use App\Entity\Symptom;
use App\Service\Symptoms;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SymptomsGetCommand extends Command
{
    protected static $defaultName = 'symptoms:get';
    protected $symptoms;
    protected $em;

    public function __construct(EntityManagerInterface $em, Symptoms $symptoms, string $name = null)
    {
        parent::__construct($name);
        $this->symptoms = $symptoms;
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('start_year', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('end_year', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $symptoms_rep = $this->em->getRepository(Symptom::class);
        $symptoms = $this->symptoms->getByRangeYear();
        foreach ($symptoms as $symptom) {
            $symptoms_rep->findByNameOrCreate($symptom);
        }

        return 0;
    }
}
