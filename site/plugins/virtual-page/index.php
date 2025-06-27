<?php

declare(strict_types=1);

// Autoloading der Modelle und Klassen (Anpassung deines Pfades)
// Stellen Sie sicher, dass 'ModuleStorePage' und die benötigten Klassen geladen werden
load(
    [
        "ModuleStorePage" => "model/ModuleStore.php", // Anpassung zum Model-Pfad
    ],
    __DIR__ // Base directory des Plugins
);


Kirby::plugin("symcon/virtual-store-test", [ // Eindeutiger Plugin-Name für das Beispiel
    'blueprints' => [],
    'pageModels' => [
        // Map den Template-Namen 'modulestore' zum ModuleStorePage-Modell
        'modulestore' => ModuleStorePage::class,
    ],
    'templates' => ['modle' => __DIR__. '/template/modle.php'],
    // Definition der virtuellen Hauptseite
    'pages' => [ "module-store" => ModuleStorePage::factory([
        "slug"         => "module-store",
        "title"        => "Module Store",
        "template"     => "modulestore",
        "translations" => [
            "de" => [
                "code"    => "de",
                "content" => [
                    "title"  => "Module Store",
                    "uuid"   => Str::uuid(),
                ],
            ]
        ],
        "draft" => false,
    ], ModuleStorePage::class, false)],
    
]);
