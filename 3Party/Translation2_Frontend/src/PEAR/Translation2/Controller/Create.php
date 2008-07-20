<?php
class PEAR_Translation2_Controller_Create extends k_Controller
{
    private $form;
    
    function __construct(k_iContext $context, $name) 
    {
        parent::__construct($context, $name);

        $this->document->title = 'Create translation';
        $this->document->options = array(
            $this->url('../') => 'Close'
        );

        $this->form = new k_FormBehaviour($this, dirname(__FILE__) . "/../templates/form-tpl.php");
        $this->form->descriptors[] = array("name" => "identifier");

        foreach ($this->getTranslation()->getLangs('ids') as $lang) {
            $this->form->descriptors[] = array("name" => "translation[".$lang."]");
        }
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

        $result = $this->getTranslationAdmin()->add($_POST['identifier'], null, $_POST['translation']);
        if (PEAR::isError($result)) {
            throw new Exception($result->getMessage());
        }
        
        throw new k_http_Redirect($this->url());
    }
}

