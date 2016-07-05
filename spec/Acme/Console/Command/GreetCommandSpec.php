<?php

namespace spec\Acme\Console\Command;

use Acme\Console\Command\GreetCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GreetCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GreetCommand::class);
    }
}
