<?php

require __DIR__ . '/kirby/bootstrap.php';

$kirby = kirby();
$staticSiteGenerator = new JR\StaticSiteGenerator($kirby);
$moduleStoreMainPage = $kirby->page("module-store");
$moduleStoreRoutes = getChildrenInformation($moduleStoreMainPage);
var_dump($moduleStoreRoutes);
function getChildrenInformation($parent): array
{
    $information = [];
    $information[] = [
        "path"         => $parent->url("de"),
        "route"        => $parent->url("de"),
        "languageCode" => "de",
    ];
    $information[] = [
        "path"         => $parent->url("en"),
        "route"        => $parent->url("en"),
        "languageCode" => "en",
    ];
    $children = $parent->children();
    //go recursive thought the pages
    foreach ($children as $child) {
        $information = array_merge(
            $information,
            getChildrenInformation($child)
        );
    }
    return $information;
}

$staticSiteGenerator->setCustomRoutes($moduleStoreRoutes);
$files = $staticSiteGenerator->generate('./build');

// For debugging we want to display which pages were rendered
foreach ($files as $file) {
    echo $file . PHP_EOL;
}
