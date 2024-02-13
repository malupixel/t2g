<?php

namespace App\Command;

use App\Service\CodeBreakerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:codebraker:decode',
    description: 'Deszyfrowanie wiadomości',
    aliases: ['app:message-decode'],
    hidden: false
)]
final class MessageDecode extends Command
{
    public function __construct(
        private readonly CodeBreakerInterface $codeBreaker,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Deszyfrowanie wiadomości')
            ->setHelp('To polecenie pozwala na deszyfrowanie wiadomości');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Dekodowanie wiadomości');

        $helper = $this->getHelper('question');
        $question = new Question('Podaj zakodowaną wiadomość:');
        $message = $helper->ask($input, $output, $question);

        if (empty($message)) {
            $io->error('Nie podano wiadomości!');
            return Command::INVALID;
        }

        $io->success($this->codeBreaker->decode(message: $message));

        return Command::SUCCESS;
    }
}
