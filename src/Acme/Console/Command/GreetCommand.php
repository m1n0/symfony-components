<?php
/**
 * Created by PhpStorm.
 * User: m1n0
 * Date: 05/07/2016
 * Time: 14:08
 */

namespace Acme\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command {

  protected function configure() {

    $this
      ->setName('demo:greet')
      ->setDescription('Greet someone')
      ->addArgument(
        'names',
        InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
        'Who do you want to greet?'
      )
      ->addOption(
        'yell',
        null,
        InputOption::VALUE_NONE,
        'If set, the task will yell in uppercase letters'
      )
      ->addOption(
        'iterations',
        'i',
        InputOption::VALUE_REQUIRED,
        'How many times should the message be printed?',
        1
      )
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $names = $input->getArgument('names');

    if ($names) {
      $text = 'Hello ' . implode(', ', $names);
    }
    else {
      $text = 'Hello';
    }

    if ($input->getOption('yell')) {
      $text = strtoupper($text);
    }

    for ($i = 0; $i < $input->getOption('iterations'); $i++) {
      $output->writeln($text);
    }
  }
}
