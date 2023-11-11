# phpcs

## Запуск

* Скачиваем phar

```bash
curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar
```

* Запускаем команду phar

```bash
 php phpcs.phar --standard=./local/modules/iny.core/phpcs.xml \
  --runtime-set testVersion 8.1 \
  ./local/
 ```

* Запускаем команду vendor

```bash
./local/modules/iny.core/vendor/bin/phpcs --standard=./local/modules/iny.core/phpcs.xml \
  --runtime-set testVersion 8.1 \
  ./local/
 ```

![Screenshot](/doc/image/example_phpcs.png)
