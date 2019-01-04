<?php
/**
 * Created by PhpStorm.
 * User: Pavlin
 * Date: 1/3/2019
 * Time: 9:09 PM
 */

namespace QuizBundle\Command;


use QuizBundle\Controller\UserController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Ranking extends Command
{
    private $userController;

    /**
     * Ranking constructor.
     * @param $userController
     */
    public function __construct(UserController $userController,$name = null)
    {
        $this->userController = $userController;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:users:ranking');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->userController->test();
       $output->writeln("cmooon");
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        parent::interact($input, $output); // TODO: Change the autogenerated stub
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output); // TODO: Change the autogenerated stub
    }

}