<?php  declare (strict_types=1);
require __DIR__ . '/vendor/autoload.php';

error_reporting((E_ERROR | E_WARNING | E_PARSE | E_NOTICE));
ini_set('display_errors', 1);

use zozor\Paginator;

$nb_line = 120; // Extract the number of rows from the database
$per_page = 10; // Number of rows displayed on a page
$max_show = 10; // Number max of buttons displayed
$nb_page = (int) ceil($nb_line / $per_page);

$current_page = isset($_GET["current_page"]) ? (int) $_GET["current_page"] : 1;
$current_page = min($nb_page -1, $current_page);
$current_page = max(1, $current_page);

print new Paginator($nb_line, $per_page, $max_show, $current_page);
