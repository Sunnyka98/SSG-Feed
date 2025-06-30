<?php

return [
    'debug' => true,
    'languages' => true,
    'routes' => [
        [
            'pattern' => 'de/feed',
            'method' => 'GET',
            'action' => function () {
                try {
                    $feed = feed(fn () => site()->index(), ['feedurl' => site()->url()."/de/feed"]);
                } catch (\Throwable $th) {
                    throw $th;
                }

                return $feed;
            }
        ],[
            'pattern' => 'en/feed',
            'method' => 'GET',
            'language' => 'en',
            'action' => function () {
                try {
                    $feed = feed(fn () => site()->index(), ['feedurl' => site()->url()."/en/feed"]);
                } catch (\Throwable $th) {
                    throw $th;
                }

                return $feed;
            }
        ],
        [
            'pattern' => 'debug-pages',
            'action' => function () {
                header('Content-Type: text/plain');
                $output = "Alle gefundenen Seiten (site()->pages()):\n";
                foreach (site()->pages() as $page) {
                    $output .= "- " . $page->uri() . " (Template: " . $page->template()->name() . ")\n";
                }
                $output .= "\nInformationen zu den virtuellen Unterseiten unter 'module-store':\n";
                $parent = page('module-store'); // Prüfe den korrekten Slug
                $output .= $parent ? "Module-Store is found" : "Module-Store is missing";
                if ($parent && $parent->children()->count() > 0) {
                    foreach ($parent->children() as $child) {
                        $output .= "- " . $child->uri() . " (Titel: " . $child->title() . ")\n";
                    }
                } else {
                    $output .= "- Keine virtuellen Unterseiten unter 'module-store' gefunden.\n";
                }
                return $output;
            }
        ],
    ],


];
