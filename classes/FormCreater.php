<?php

class FormCreater
{
    private string $form;
    private array $inputs;

    public function __construct(string $method, string $action, string $enctype)
    {
        $this->form = "<form method=\"$method\" action=\"$action\" enctype=\"$enctype\">";
    }

    public function createForm(array $inputs)
    {
        $this->inputs = $inputs;
        foreach ($inputs as $key => $value) 
        {
            $this->createInput($value, $key);
        }

        $this->form .= "    <input type=\"reset\" value=\"Effacer\" />
            <input type=\"submit\" value=\"S'inscrire\" name=\"inscription\"/>
            </form>";

        echo $this->form;
    }

    private function createInput($inputType, $name)
    {
        $this->form .= "<label for=\"$name\"> $name : </label>";

        switch ($inputType) 
        {
            case InputType::Text;
                $this->form .= "<input type=\"texte\" id=\"$name\" name=\"$name\" value=\"<?php echo \$$name;?>\" /><br />"; 
                break;

            case InputType::File;
                $this->form .= "<input type=\"file\" id=\"$name\" name=\"$name\" value=\"<?php echo \$$name;?>\" /><br />"; 
                break;

            case InputType::Password;
                $this->form .= "<input type=\"password\" id=\"$name\" name=\"$name\" value=\"\" /><br />"; 
                break;

            case InputType::LongText;
                $this->form .= "<textarea id=\"$name\" name=\"$name\" value=\"<?php echo \$$name;?>\"></textarea><br />";          
                break;

            default:
        }
    }
}
