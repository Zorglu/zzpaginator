ZZPaginator

[![license][icon-version]][link-packagist]
[![license][icon-downloads]][link-packagist]
[![license][icon-license]][link-license]
[![license][icon-php]][link-php]
=============



A simple paginator for PHP ^8.3 for use with javascript fetch.
The HTML page without PHP, which will display rows extracted from a database, will make a request in JavaScript using `fetch()` to a PHP page that will return the retrieved rows along with pagination data.

The PHP page, which will fetch the rows from the database, can initialize the `zozor/paginator` class to create a pagination tool. All of this can be returned to JavaScript in JSON format.

## Installation

### Requirements

Paginator requires [PHP][link-php] 8.3 or higher.

### Using Composer

The recommended way to install Paginator is with [Composer][link-composer], a dependency manager for PHP.

You should just add `zozor/paginator` to your project dependencies in `composer.json`. It is recommended to add them manually to `composer.json`

```json
{
    "require": {
        "zozor/paginator": "^1.0"
    }
}
```
or
```bash
composer require zozor/paginator
```

### Manually Installation

Alternatively, you could download all files in the [`src`][link-handlers] directory from GitHub and then manually include them in your script.

## Example of Usage (file : get_pagination.php)
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
## Example of Usage (file : test_pagination.html)
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example zzPaginator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<body>
    <h1>Pagination example with <a href="https://getbootstrap.com/" taget="_blank">Bootstrap</a> integration</h1>
    <hr>
    <ul class="pagination" id="paginate"></ul>

<style>
.pagination li a{
    cursor: pointer;
}
</style>

<script>

async function getPagination(page){

    const response = await fetch(`./get_pagination.php?current_page=${page}`);
    const json = await response.json();

    let s = ``;

    for(let item in json){
        s += `<li class="page-item">`;
        s += `<a onclick="getPagination(${json[item].num}); return false;" class="page-link ${json[item].num == page ? "active" : ""}">${json[item].text}</a>`
        s += `</li>`;
    }

    document.querySelector("#paginate").innerHTML = s;
}

getPagination(1);
</script>
</body>
</html>
```
## Versioning

This library uses [SemVer][link-semver] SemVer for versioning. For the versions available, see the [tags on this repository][link-tags].

## License

This library is licensed under the MIT license. See the [LICENSE][link-license] file for details.

### Inspiration
Inspired by [jasongrimes/php-paginator][link-inspired]

[icon-version]:https://img.shields.io/packagist/v/zozor/paginator.svg?style=flat-square
[icon-license]:https://img.shields.io/packagist/l/zozor/paginator.svg?style=flat-square&label=license
[icon-downloads]:https://img.shields.io/packagist/dt/zozor/paginator.svg?style=flat-square&label=downloads
[icon-php]:https://img.shields.io/packagist/dependency-v/zozor/paginator/php.svg?label=php&style=flat-square

[link-packagist]:https://packagist.org/packages/zozor/paginator
[link-license]:https://github.com/Zorglu/zzpaginator/blob/main/LICENSE.md
[link-php]:https://php.net/
[link-tags]:https://github.com/Zorglu/zzpaginator/tags/
[link-semver]: https://semver.org/
[link-composer]:https://getcomposer.org/
[link-handlers]:https://github.com/Zorglu/zzpaginator/tree/main/src
[link-inspired]:https://github.com/jasongrimes/php-paginator/blob/master/README.md?plain=1