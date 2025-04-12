ZZPaginator
[![Latest Version on Packagist](https://img.shields.io/packagist/v/zozor/paginator.svg?style=flat-square)](https://packagist.org/packages/zozor/paginator)
[![Total Downloads](https://img.shields.io/packagist/dt/zozor/paginator.svg?style=flat-square)](https://img.shields.io/packagist/dt/zozor/paginator.svg)
=============


A simple paginator for PHP ^8.3 for use with javascript fetch.
The HTML page without PHP, which will display rows extracted from a database, will make a request in JavaScript using `fetch()` to a PHP page that will return the retrieved rows along with pagination data.

The PHP page, which will fetch the rows from the database, can initialize the `zozor\Paginator` class to create a pagination tool. All of this can be returned to JavaScript in JSON format.

## Example of Usage
```php
<?php  declare (strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use zozor\Paginator;

$nb_line = 120; // Extract the number of rows from the database
$per_page = 10; // Number of rows displayed on a page
$max_show = 10; // Number max of buttons displayed
$nb_page = (int) ceil($nb_line / $per_page);

$current_page = isset($_GET["current_page"]) ? (int) $_GET["current_page"] : 1;
$current_page = min($nb_page -1, $current_page);
$current_page = max(1, $current_page);

print new Paginator($nb_line, $per_page, $max_show, $current_page);

```

Inspired by [jasongrimes/php-paginator](https://github.com/jasongrimes/php-paginator/blob/master/README.md?plain=1)

