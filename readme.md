Yandex Referat Parser
=====================

Parsing the: [https://referats.yandex.ru/referats](https://referats.yandex.ru/referats)

`git clone git@github.com:amberlex78/yandex-referat-parser.git`

`cd yandex-referat-parser`

`composer install`

Create DB and Import `referats.sql` file.

Connect to DB in index.php file.

`$db = new DB('root', 'root', 'yandex');`