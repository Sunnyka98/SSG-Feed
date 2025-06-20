<?php

require __DIR__ . '/kirby/bootstrap.php';

$kirby = kirby();
$staticSiteGenerator = new JR\StaticSiteGenerator($kirby);
$files = $staticSiteGenerator->generate('./build');

// For debugging we want to display which pages were rendered
foreach ($files as $file) {
    echo $file . PHP_EOL;
}
