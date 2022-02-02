<?php

class XSSPreventer
{
    public static function escapeSpecialCharacters()
    {
        foreach ($_POST as $key => $value) 
        {
            $value = htmlentities($value);
        } 
    }
}