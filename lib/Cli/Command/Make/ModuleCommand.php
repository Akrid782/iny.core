<?php

namespace INY\Core\Cli\Command\Make;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use INY\Core\Infrastructure\Repository\ModuleRepository;
use INY\Core\Service\ModuleService;
use INY\Core\UseCase\CreateModule\CreateModuleHandler;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * class ModuleCommand
 *
 * @author  Иванов Николай <n.ivanov@mcart.ru>
 * @package INY\Core\Cli\Command
 */
class ModuleCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('make:module')
            ->setDescription('Создание модуля по шаблону.');
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ArgumentException
     * @throws ObjectNotFoundException
     * @throws SystemException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $moduleId = (string) $this->askQuestion($input, $output, 'Идентификатор модуля:');
        $dir = (string) $this->askChoiceQuestion($input, $output, 'Путь создания модуля (по умолчанию local):', [
            'local',
            'bitrix',
        ]);

        $repository = new ModuleRepository();
        $moduleService = new ModuleService(new CreateModuleHandler($repository));
        $moduleService->create([
            'id' => $moduleId,
            'name' => (string) $this->askQuestion($input, $output, 'Имя модуля:'),
            'description' => (string) $this->askQuestion($input, $output, 'Описание модуля:'),
            'phpVersion' => (float) $this->askChoiceQuestion($input, $output, 'Версия php (по умолчанию 8.1):', [
                8.1,
                8.2,
                8.3,
            ]),
            'partnerName' => (string) $this->askQuestion($input, $output, 'Имя партнера:'),
            'partnerUri' => (string) $this->askQuestion($input, $output, 'URI партнера:'),
            'dir' => $dir,
        ]);

        $output->writeln([
            '<info>',
            'SUCCESS',
            '==================================',
            'Модуль "' . $moduleId . '" создан.',
            'Путь до модуля ' . Application::getDocumentRoot() . '/' . $dir . '/' . $moduleId . '/',
            '==================================',
            '</info>',
        ]);

        return Command::SUCCESS;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param non-empty-string $question
     *
     * @return string|null
     */
    private function askQuestion(
        InputInterface $input,
        OutputInterface $output,
        string $question
    ): mixed {
        $questionHelper = new QuestionHelper();
        $question = new Question($question);

        return $questionHelper->ask($input, $output, $question);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param non-empty-string $question
     * @param list<mixed> $choiceQuestionList
     *
     * @return mixed
     */
    private function askChoiceQuestion(
        InputInterface $input,
        OutputInterface $output,
        string $question,
        array $choiceQuestionList
    ): mixed {
        $questionHelper = new QuestionHelper();
        $question = new ChoiceQuestion($question, $choiceQuestionList, 0);

        return $questionHelper->ask($input, $output, $question);
    }
}
