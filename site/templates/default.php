<h1><?= $page->title() ?></h1>
<?php
    if (!function_exists("getOverviewTable")) {
        function getOverviewTable($page, $depth)
        {
            $result = "";
            $pages = false;
            if ($page->hasChildren()) {
                $pages = $page->children();
            }
            if (isset($pages) && $pages != false) {
                if ($depth == 2) {
                    $result .= "<table>";
                }
                foreach ($pages as $page) {
                    switch ($depth) {
                        case 3:
                            $result .= "<h3><a href='" . $page->url() . "/'>" . $page->title() . "</a></h3>\n";
                            $result .= "<p><b>" . $page->text() . "</b></p>\n";
                            $result .= getOverviewTable($page, $depth - 1);
                            break;
                        case 2:
                            $hasChild = getOverviewTable($page, $depth - 1) != "";
                            $result .= "<tr>\n";
                            $result .= "<td><a href='" . $page->url() . "/'>" . $page->title() . "</a></td>\n";
                            $result .= "<td>" . $page->text() . "</td>\n";
                            $result .= "</tr>\n";
                            if ($hasChild) {
                                $result .= "<tr>\n";
                                $result .= "<td>\n";
                                $result .= "<table>\n";
                                $result .= getOverviewTable($page, $depth - 1);
                                $result .= "</table>\n";
                                $result .= "</td>\n";
                                $result .= "</tr>\n";
                            }
                            break;
                        case 1:
                            $result .= "<tr>\n";
                            $result .= "<td><a href='" . $page->url() . "/'>" . $page->title() . "</a></td>\n";
                            $result .= "<td>" . $page->text() . "</td>\n";
                            $result .= "</tr>\n";
                            break;
                    }
                }
                if ($depth == 2) {
                    $result .= "</table>\n";
                }
            }
            return $result;
        }
    }
?>

<style>
	table,
	tr,
	td {
		border: thin solid;
	}
</style>
<?php
    echo $page->text()->kt();
//depth = 3 if the children is overwiev
$pages = $page->children();
if ($pages != false) {
    echo getOverviewTable($page, 3);
}

$children = $site->children();
foreach ($children as $child) {
    echo "<a href='" . $child->url() . "/'>" . $child->title() . "</a><br>\n";
    if($child->hasChildren()){
        foreach ($child->children() as $grand) {
            echo "-<a href='" . $grand->url() . "/'>" . $grand->title() . "</a><br>\n";
        }
    }
}
?>