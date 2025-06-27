<?php

declare(strict_types=1);

use Kirby\Cms\Page;

class ModuleStorePage extends Page
{
    private function slugifyGermanString(string $unsafeString): string
    {
        $string = str_replace(["ä", "ö", "ü", "ß"], ["ae", "oe", "ue", "ss"], $unsafeString);
        return Str::slug(lcfirst($string));
    }


    public function children(): Pages
    {
        // Diese Zeile sollte jetzt die korrekte Überprüfung sein,
        // ob die Kinder schon geladen sind, bevor wir sie neu generieren.
        // parent::children() ruft die Methode der Elternklasse auf, die einen internen Cache hat.
        if (parent::children()->isNotEmpty()) {
            return parent::children();
        }

        // Simuliere DataController, falls er nicht sofort verfügbar ist oder du einen Mock brauchst
        // Für das Minimalbeispiel ohne externe Abhängigkeiten:
        $dc = new class () {
            public function getCategories(): array
            {
                return [
                    "category-a" => ["name" => ["de" => "Kategorie A", "en" => "Category A"]],
                    "category-b" => ["name" => ["de" => "Kategorie B", "en" => "Category B"]]
                ];
            }
            public function getModuleIdsByCategory(string $categoryId, string $lang): array
            {
                return ["module-1", "module-2"];
            }
            public function getAllModules(): array
            {
                // Returniere Mock-Objekte, die getName() und getBundle() haben
                return [
                    "module-a" => new class () {
                        public function getName(string $lang)
                        {
                            return 'Module A ' . $lang;
                        } public function getBundle()
                        {
                            return 'bundle-a';
                        }
                    },
                    "module-b" => new class () {
                        public function getName(string $lang)
                        {
                            return 'Module B ' . $lang;
                        } public function getBundle()
                        {
                            return 'bundle-b';
                        }
                    }
                ];
            }
        };

        // Wenn dein DataController eine Singleton-Instanz ist:
        // $dc = DataController::getInstance($this->kirby());

        $virtualChildren = [];

        // ModulePages (vereinfacht für Minimalbeispiel)
        foreach ($dc->getAllModules() as $key => $module) {
            $virtualChildren['module-store/'.$key] = [
                'slug'   => Str::slug($key),
                'template' => 'modle',
                'content' => [
                    'title' => $module->getName('de'),
                    'bundle' => $module->getBundle('de'),
                    'uuid' => Str::uuid(),
                ],
                'parent' => $this->id(), 
            ];
        }

        // Cache die generierten Kinder in der internen children-Property der Seite
        // Dies stellt sicher, dass sie nur einmal generiert werden
        return $this->children = Pages::factory($virtualChildren, $this, false);
    }
}
