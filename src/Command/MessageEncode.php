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
    name: 'app:codebraker:encode',
    description: 'Szyfrowanie wiadomości',
    aliases: ['app:message-encode'],
    hidden: false
)]
final class MessageEncode extends Command
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
            ->setDescription('Szyfrowanie wiadomości')
            ->setHelp('To polecenie pozwala na szyfrowanie wiadomości');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Kodowanie wiadomości');

        $helper = $this->getHelper('question');
        $question = new Question('Podaj wiadomość do zakodowania:');
        $message = $helper->ask($input, $output, $question);

        if (empty($message)) {
            $io->error('Nie podano wiadomości!');
            return Command::INVALID;
        }

        $io->success($this->codeBreaker->encode(message: $message));

        return Command::SUCCESS;
    }
}
