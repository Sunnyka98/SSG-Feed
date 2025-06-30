<?php

require __DIR__ . '/kirby/bootstrap.php';

$kirby = kirby();
$staticSiteGenerator = new JR\StaticSiteGenerator($kirby);
$moduleStoreMainPage = $kirby->page("module-store");
$moduleStoreRoutes = getChildrenInformation($moduleStoreMainPage);
$customRoutes = array_merge($moduleStoreRoutes, [[
        "path"  => "feed-de.xml",
        "route" => "de/feed",
        "language" => "de",
    ],
    [
        "path"  => "feed-en.xml",
        "route" => "en/feed",
        "language" => "en",
    ],]);
var_dump($customRoutes);
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

$staticSiteGenerator->setCustomRoutes($customRoutes);
$files = $staticSiteGenerator->generate('./build');

// For debugging we want to display which pages were rendered
foreach ($files as $file) {
    echo $file . PHP_EOL;
}
