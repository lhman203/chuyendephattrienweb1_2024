<?php 
declare(strict_types=1);
require_once 'src/I.php';
require_once 'src/A.php';
require_once 'src/B.php';
require_once 'src/C.php';

Class demo{
    public function TypeXRreturnY(): X{
        echo __FUNCTION__."\n";
        return new Y();
    }
}
$demo = New demo();
$result = $demo->TypeXRreturnY();
var_dump(result);