<?php

namespace INY\Core\Cli\Command\Make;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\ObjectNotFoundException;
use Bitrix\Main\SystemException;
use INY\Core\Domain\Exception\ModuleValidationException;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * class ModuleCommand
 *
 * @author  Иванов Николай <akrid782@mail.ru>
 * @package INY\Core\Cli\Command
 */
#[AsCommand(name: 'make:module', description: 'Создание модуля по шаблону.')]
class ModuleCommand extends Command
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ArgumentException
     * @throws ObjectNotFoundException
     * @throws SystemException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $status = Command::SUCCESS;

        $phpVersion = PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;
        $phpVersion = (float) $this->askChoiceQuestion($input, $output, "Версия php (по умолчанию $phpVersion):", [
            7.4,
            8.1,
            8.2,
            8.3,
        ], $phpVersion);
        $moduleId = (string) $this->askQuestion($input, $output, 'Идентификатор модуля:');
        $moduleName = (string) $this->askQuestion($input, $output, 'Имя модуля:');
        $moduleDescription = (string) $this->askQuestion($input, $output, 'Описание модуля:');
        $partnerName = (string) $this->askQuestion($input, $output, 'Имя партнера:');
        $partnerUri = (string) $this->askQuestion($input, $output, 'URI партнера:');

        try {
            ServiceLocator::getInstance()->get('iny.service.module.create')->create([
                'id' => $moduleId,
                'name' => $moduleName,
                'description' => $moduleDescription,
                'phpVersion' => $phpVersion,
                'partnerName' => $partnerName,
                'partnerUri' => $partnerUri,
            ]);

            $output->writeln([
                '<info>',
                'SUCCESS',
                '==================================',
                'Модуль "' . $moduleId . '" создан.',
                'Путь до модуля ' . Application::getDocumentRoot() . '/local/' . $moduleId . '/',
                '==================================',
                '</info>',
            ]);
        } catch (ModuleValidationException $exception) {
            $output->writeln([
                '<error>ERROR</error>',
                '<fg=#c0392b>==================================',
                'Сообщение об ошибке: ' . $exception->getMessage(),
                'Введенное значение: ' . $exception->getInvalidValue(),
                '==================================</>',
            ]);

            $status = Command::FAILURE;
        }

        return $status;
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
        return (new QuestionHelper())->ask($input, $output, new Question($question));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @param non-empty-string $question
     * @param list<mixed> $choiceQuestionList
     * @param bool|float|int|string|null $defaultValue
     *
     * @return mixed
     */
    private function askChoiceQuestion(
        InputInterface $input,
        OutputInterface $output,
        string $question,
        array $choiceQuestionList,
        bool|float|int|null|string $defaultValue = 0
    ): mixed {
        return (new QuestionHelper())->ask(
            $input,
            $output,
            new ChoiceQuestion($question, $choiceQuestionList, $defaultValue)
        );
    }
}
