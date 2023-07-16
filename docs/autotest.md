# Инструкция по автотестам

## Запуск phpcs

### Локальный запуск

* Качаем phar

```bash
curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
```

* Запускаем команду

```bash
 php phpcs.phar --standard=./local/modules/iny.core/phpcs.xml \
  --runtime-set testVersion 8.1 \
  ./local/modules/iny.core/
 ```

![Screenshot](/docs/images/example_phpcs.png)

### Настройка CI/CD

* **JOB** - Название файла для job, например phpcs.yml
* **PATH** - Путь до проверяемой директории/файла, например ./
* **PATH_TO_CONFIG** - Путь до конфига, например ./local/modules/iny.core или ./bitrix/modules/iny.core

#### github

```yml
name: "PHPCS"

on:
  push:
    tags:
      - '!refs/tags/*'
    branches:
      - '*'
    paths:
      - "**.php"
      - ".github/workflows/${JOB}"

jobs:
  phpcs:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
        with:
          fetch-depth: 0 # important!

      - name: Install PHP_CodeSniffer
        run: |
          curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
          php phpcs.phar --version

      - name: Run PHP_CodeSniffer
        run: |
          php phpcs.phar --standard=./#PATH_TO_CONFIG#/phpcs.xml --runtime-set testVersion 8.1 #PATH#
```

#### gitlab

```yml
image: php-builder:latest

stages:
  - tests

phpcs:
  allow_failure: false
  stage: test
  only:
    - merge_requests
  image: registry.gitlab.com/pipeline-components/php-codesniffer:latest
  before_script:
    - mkdir -p logs
  script:
    - echo phpcs --version
    - phpcs --standard=./#PATH_TO_CONFIG#/phpcs.xml --runtime-set testVersion 8.1 #PATH#
  artifacts:
    reports:
      junit: logs/junit.xml
    name: checkstyle.html
    paths:
      - logs/checkstyle.xml
      - checkstyle.txt
```
