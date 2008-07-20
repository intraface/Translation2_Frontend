<?php
class PEAR_Translation2_Controller_Lang_Index extends k_Controller
{
    public $map = array('create' => 'PEAR_Translation2_Controller_Lang_Create');

    function GET()
    {
        $this->document->title = 'Languages';
        $this->document->options = array(
            $this->url('create') => 'Create',
            $this->url('../') => 'Close'
        );
    
        $data = array(
            'langs' => $this->context->getTranslation()->getLangs()
        );
        
        return $this->render(dirname(__FILE__) . '/../../templates/languages-tpl.php', $data);
    }

    function forward($name)
    {
        if (!isset($this->map[$name])) {
            throw new Exception('Unqualified mapping');
        }

        $next = new $this->map[$name]($this, $name);
        return $next->handleRequest();
    }
}

