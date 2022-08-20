<h1>mnemesong/table-schema</h1>

[![Latest Stable Version](http://poser.pugx.org/mnemesong/table-schema/v)](https://packagist.org/packages/mnemesong/table-schema)
[![PHPUnit](https://github.com/mnemesong/table-schema/actions/workflows/phpunit.yml/badge.svg)](https://github.com/mnemesong/table-schema/actions/workflows/phpunit.yml)
[![PHPStan-lvl9](https://github.com/mnemesong/table-schema/actions/workflows/phpstan.yml/badge.svg)](https://github.com/mnemesong/table-schema/actions/workflows/phpstan.yml)
[![PHP Version Require](http://poser.pugx.org/mnemesong/table-schema/require/php)](https://packagist.org/packages/mnemesong/table-schema)
[![License](http://poser.pugx.org/mnemesong/table-schema/license)](https://packagist.org/packages/mnemesong/table-schema)

- The documentation is written in two languages: Russian and English.
- Документация написана на двух языках: русском и английском.

<hr>

<h2>General description / Общее описание</h2>
<h3>ENG:</h3>
<p>The package provides objects and mechanics for creating abstract table schemas and tabular columns without binding
to a particular type of database. Table and column objects contain only the necessary data structure to describe a column on any
database. Features that are not typical for all types of storage are implemented using the mechanics of specifications:
A specification is a pair: an identifier and an attached value. Initially, a ppackage does not contain any specifications.
Specifications and the mechanics of their processing should be implemented based on specific storage types.</p>

<h3>RUS:</h3>
<p>Пакет предосталвяет объекты и механики для создания абстрактных схем таблиц и табличных колонок без привязки
к конкретному виду БД. Объекты таблиц и колонок содержат только необходимую структуру данных, для описания колонки на любой
базе данных. Возможности характерные не для всех типов хранилищ реализованы с помощью механики спецификаций: 
Спецификация это пара: идентификатор и прилагающееся значение. Изначально ппакет не содержит никаких спецификаций.
Спецификации и механика их обработки должны быть реализованы на базе конкретных типов хранилищ.</p>
<hr>

<h2>Requirements / Требования</h2>
<ul>
    <li>PHP >= 7.4</li>
    <li>Composer >=2.0</li>
</ul>
<hr>

<h2>Installation / Установка</h2>
<p>composer require "mnemesong/table-schema"</p>
<hr>

<h2>License / Лицензия</h2>
- MIT
<hr>

<h2>Contacts / Контакты</h2>
- Anatoly Starodubtsev "Pantagruel74"
- tostar74@mail.ru