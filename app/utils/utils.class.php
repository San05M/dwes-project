<!-- TODO: Trasladar luego -->
<?php
function esOpcionMenuActiva($opcion)
{
    $actual = explode('/', $_SERVER['REQUEST_URI']);
    $actual = '/' . $actual[count($actual) - 1];
    if ($actual === $opcion) {
        return true;
    } else {
        return false;
    }
}
?>