<?php
function inclureClass($className)
{
    if (file_exists($fichier = __dir__ . "/" . $className . ".php")) {
        require "$fichier";
    }
}
spl_autoload_register('inclureClass');
?>
