<?php

/*
 * This file is part of the nodika project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command;

use App\Entity\ImportDirectory;
use SensioLabs\Security\Command\SecurityCheckerCommand;
use SensioLabs\Security\SecurityChecker;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 06/01/2018
 * Time: 19:47.
 */
class ImportCommand extends ContainerAwareCommand
{
    private $doctrine;

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('import:all')
            // the short description shown while running "php bin/console list"
            ->setDescription('Import data from a csv.')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('initialize database...');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {    // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Checking for valididy',
        ]);

        $this->doctrine = $this->getContainer()->get("doctrine");
        $manager = $this->doctrine->getManager();

        $output->writeln("");
        $jobsHandle = fopen(dirname(__DIR__) . "/Import/import.csv", "r");
        $skips = 2;

        while (($row = fgetcsv($jobsHandle, null, ",")) !== false) {
            if ($skips-- > 0) {
                continue;
            } else if ($skips < -200) {
                break;
            }

            $import = new ImportDirectory();
            $import->setName($row[9]);
            $import->setDescription($row[10]);

            $import->setStreet($row[4]);
            $import->setStreetNr(0);
            $import->setPostalCode($row[5]);
            $import->setCity($row[6]);
            $import->setCountry($row[8]);

            $import->setImageGuid($row[15]);
            $import->setRendingPrice($row[12]);
            $import->setSellingPrice($row[11]);
            $import->setCategory($row[0]);

            $manager->persist($import);
        }
        $manager->flush();


        $output->writeln("ALL DONE" . $skips);
    }

}
