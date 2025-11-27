<?php

namespace App\Command;

use App\Entity\Carrier;
use App\Repository\CarrierRepository;
use App\Service\TrackingAgent\TrackingAgentSelector;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:pull-carriers',
    description: '通过代理商拉取承运商信息',
)]
class PullCarriersCommand extends Command
{
    public function __construct(private readonly CarrierRepository $carrierRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

//        foreach ($this->agentSelector->getAllAgents() as $agent) {
//           //todo
//        }

        $this->initCarriers();

        return Command::SUCCESS;
    }

    protected function initCarriers()
    {
        $seeds = [
            [
                'code' => 'fedex',
                'name' => 'Fedex',
            ],
            [
                'code' => 'ups',
                'name' => 'UPS',
            ],
        ];
        foreach ($seeds as $seed) {
            $record = new Carrier();
            $record->setCarrierCode($seed['code'])
                ->setCarrierName($seed['name'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());
            $this->carrierRepository->getEntityManager()->persist($record);
        }
        $this->carrierRepository->getEntityManager()->flush();
    }
}
