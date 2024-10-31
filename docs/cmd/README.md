# Консольные команды

## Старт работ

Перед началом работ, нужно установить composer по документации
bitrix https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=4637
или выполнить команду в корне модуля

```bash
make init
```

## Команды

### Создание модуля

Чтобы создать модуль по шаблону, есть два пути:

1. Выполнить команду в корне ядра bitrix, как в документации
   https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=11685&LESSON_PATH=3913.3516.4776.2483.11685
    ```bash
    php bitrix.php make:module
    ```
2. Выполнить команду из корня модуля

```bash
make create-module
```
