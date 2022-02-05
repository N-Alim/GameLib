<?php
function showAvatars()
{
    $functions = glob("./avatars/*");
    foreach ($functions as $key => $value) 
    {
        echo "<img src=\"$value\" class='avatar'>";
    }

}
