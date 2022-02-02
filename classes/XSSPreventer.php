<?php

class XSSPreventer
{
    public static function escapeSpecialCharacters()
    {
        foreach ($_REQUEST as $key => $value) 
        {
            $value = htmlentities($value);
        } 
    }
}