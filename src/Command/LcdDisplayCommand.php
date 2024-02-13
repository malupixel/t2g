<?php

namespace App\Command;

use App\Service\LcdDisplay;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:lcd:show',
    description: 'Wyświetlanie liczby w stylu LCD',
    aliases: ['app:lcd-show'],
    hidden: false
)]
final class LcdDisplayCommand extends Command
{
    public function __construct(
        private readonly LcdDisplay $lcdDisplay,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Wyświetlacz cyfr w stylu LCD')
            ->setHelp('To polecenie pozwala na wyświetlenie liczby w stylu LCD');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('LCD display');

        $helper = $this->getHelper('question');
        $question = new Question('Wpisz cyfry:');
        $message = $helper->ask($input, $output, $question);

        if (empty($message)) {
            $io->error('Nic nie wpisano!!');
            return Command::INVALID;
        }

        $io->writeln($this->lcdDisplay->show(message: $message));

        return Command::SUCCESS;
    }
}