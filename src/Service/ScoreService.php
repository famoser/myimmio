<?php
/**
 * Created by PhpStorm.
 * User: famoser
 * Date: 22/02/2018
 * Time: 08:57
 */

namespace App\Service;


use App\Entity\Application;
use App\Entity\ApplicationSlot;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ScoreService
{

    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function getScore(Application $application)
    {
        $slot = $this->registry->getRepository(ApplicationSlot::class)->findOneBy(['id' => $application->getApplicationSlot()->getId()]);
        $maxSalary = 1;
        /**
         * @var Application $app
         */
        foreach($slot->getApplications() as $app){
            $maxSalary = max($maxSalary, $app->yearlySalary());
        }
        $score = $application->yearlySalary() / $maxSalary * 100;
        $score -= 2*$application->getTenantCountChild() + $application->getApplicants()->count();

        if(!empty($application->getInstruments())) {
            $score *= .9;
        }
        if(!empty($application->getPets())) {
            $score *= .95;
        }
        $score = max(0, $score);
        return (int) $score;
    }
}