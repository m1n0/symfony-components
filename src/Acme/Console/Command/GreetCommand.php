<?php
/**
 * Created by PhpStorm.
 * User: m1n0
 * Date: 05/07/2016
 * Time: 14:08
 */

namespace Acme\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

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
    $iterations = $input->getOption('iterations');

    $progress = new ProgressBar($output, $iterations);
    $table = new Table($output);

    /** @var QuestionHelper $questionHelper */
    $questionHelper = $this->getHelper('question');

    if ($names) {
      $names = implode(', ', $names);
    }
    else {
      $question = new Question('Please provide at least one name (multiple names separated by spaces):', 'world');
      $names = $questionHelper->ask($input, $output, $question);
    }

    $text = 'Hello ' . $names;

    if ($input->getOption('yell')) {
      $text = strtoupper($text);
    }

    $question = new ConfirmationQuestion(
      sprintf('Are you sure you want to print that out %d times? [y/n] ', $iterations),
      false
    );

    if (!$questionHelper->ask($input, $output, $question)) {
      return;
    }

    $table->setHeaders(['#', 'Message']);

    $output->writeln('Preparing output...');
    $progress->start();
    for ($i = 0; $i < $iterations; $i++) {
      $table->addRow([$i, $text]);
      $progress->advance();
      sleep(1);
    }
    $progress->finish();

    $output->writeln('');
    $table->render();
  }
}
