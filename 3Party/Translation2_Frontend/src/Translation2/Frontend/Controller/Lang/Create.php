<?php
class Translation2_Frontend_Controller_Lang_Create extends k_Controller
{
    private $form;
    
    function __construct(k_iContext $context, $name) 
    {
        parent::__construct($context, $name);
        
        $this->document->title = 'Add language';
        
        $this->form = new k_FormBehaviour($this, dirname(__FILE__) . "/../../templates/form-tpl.php");
        $this->form->descriptors[] = array("name" => "lang_id");
        $this->form->descriptors[] = array("name" => "table_name");
        $this->form->descriptors[] = array("name" => "name");
        $this->form->descriptors[] = array("name" => "meta");
        $this->form->descriptors[] = array("name" => "error_text");
        $this->form->descriptors[] = array("name" => "encoding");
    }
 
    function execute() 
    {
        return $this->form->execute();
    }

    function getTranslationAdmin()
    {
        return $this->registry->get('translation_admin');
    }

    function getTranslation()
    {
        return $this->registry->get('translation'); 
    }

    function validate()
    {
        return true;
    }

    function validHandler()
    {
        $this->getTranslationAdmin()->addLang($this->POST->getArrayCopy());
        
        throw new k_http_Redirect($this->url('../'));
    }
}

