<?php

$result = exec ("R --vanilla --slave '--args 41' < /var/www/clondiag/R/code.R");
echo $result;

?>