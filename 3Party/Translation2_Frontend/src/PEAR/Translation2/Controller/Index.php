<?php
class PEAR_Translation2_Controller_Index extends k_Controller
{
    public $map = array('create' => 'PEAR_Translation2_Controller_Create',
                        'language' => 'PEAR_Translation2_Controller_Lang_Index');

    function GET()
    {
        $this->document->title = 'Translation';
        $this->document->options = array(
            $this->url('language') => 'Add language',
            $this->url('create') => 'Create translation'
        );
        
        $this->getTranslation()->setLang('da');
        $translations = $this->getTranslation()->getPage(null);
        
        $content = $this->render(dirname(__FILE__) . '/../templates/index-tpl.php', array('translations' => $translations));
        return $this->render(dirname(__FILE__) . '/../templates/wrapper-tpl.php', $data = array('content' => $content));
    }

    function getTranslationAdmin()
    {
        return $this->registry->get('translation_admin');
    }

    function getTranslation()
    {
        return $this->registry->get('translation'); 
    }
    
    function forward($name)
    {
        if (!isset($this->map[$name])) {
            throw new Exception('Unqualified mapping');
        }

        $next = new $this->map[$name]($this, $name);
        $content = $next->handleRequest();
        return $this->render(dirname(__FILE__) . '/../templates/wrapper-tpl.php', $data = array('content' => $content));
        
    }
}

