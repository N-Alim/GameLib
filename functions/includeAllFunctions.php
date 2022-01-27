<?php
function includeAllFunctions()
{
    $functions = glob("./functions/*.php");
    foreach ($functions as $key => $value) 
    {
        if ($value !== "./functions/includeAllFunctions.php")
        {
            require_once $value;    
        }
    }

}
