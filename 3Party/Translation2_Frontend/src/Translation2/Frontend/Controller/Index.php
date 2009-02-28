<?php
class Translation2_Frontend_Controller_Index extends k_Controller
{
    public $map = array('create' => 'Translation2_Frontend_Controller_Create',
                        'language' => 'Translation2_Frontend_Controller_Lang_Index');

    function GET()
    {
        $this->document->title = 'Translation';
        $this->document->options = array(
            $this->url('language') => 'Add language'
        );
        
        $data['created_page_id'] = $this->getCreatedPageId();
        
        $content = $this->render('Translation2/Frontend/templates/create-tpl.php', $data);
        return $this->render('Translation2/Frontend/templates/wrapper-tpl.php', $data = array('content' => $content));
    }
    
    function POST()
    {
        
        if(isset($this->POST['new_page_id'])) {
            $page_id = $this->POST['new_page_id'];
        } elseif($this->POST['page_id'] == '<none>') {
            $page_id = null;
        } else {
            $page_id = $this->POST['page_id'];
        }
        
        $result = $this->getTranslationAdmin()->add($this->POST['identifier'], $page_id, $this->POST['translation']);
        if (PEAR::isError($result)) {
            throw new Exception($result->getMessage());
        }
        
        
        
    }

    function getTranslationAdmin()
    {
        return $this->registry->get('translation_admin');
    }

    function getTranslation()
    {
        return $this->registry->get('translation'); 
    }
    
    function getCreatedPageId()
    {
        $created_page_id = $this->getTranslationAdmin()->getPageNames();
        $created_page_id = array_filter($created_page_id);
        if(count($created_page_id) == 0) $created_page_id[] = '<none>'; 
        return $created_page_id;
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

