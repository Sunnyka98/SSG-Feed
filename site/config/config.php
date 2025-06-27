<?php

return [
    'debug' => true,
    // 'url' => 'http://localhost:8000', // Nur falls Kirby in einem Unterverzeichnis läuft
    'languages' => true, // Wichtig für mehrsprachige virtuelle Seiten
    'routes' => [ // Debug-Route hier, da sie nicht Teil des Plugins ist
        [
            'pattern' => 'debug-pages',
            'action' => function() {
                header('Content-Type: text/plain');
                $output = "Alle gefundenen Seiten (site()->pages()):\n";
                foreach (site()->pages() as $page) {
                    $output .= "- " . $page->uri() . " (Template: " . $page->template()->name() . ")\n";
                }
                $output .= "\nInformationen zu den virtuellen Unterseiten unter 'module-store':\n";
                $parent = page('module-store'); // Prüfe den korrekten Slug
                $output .= $parent ? "Module-Store is found": "Module-Store is missing";
                if ($parent && $parent->children()->count() > 0) {
                    foreach ($parent->children() as $child) {
                        $output .= "- " . $child->uri() . " (Titel: " . $child->title() . ")\n";
                    }
                } else {
                    $output .= "- Keine virtuellen Unterseiten unter 'module-store' gefunden.\n";
                }
                return $output;
            }
        ]
    ]
];