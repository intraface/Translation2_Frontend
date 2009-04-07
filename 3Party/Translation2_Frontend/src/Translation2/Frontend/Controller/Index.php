<?php
class Translation2_Frontend_Controller_Index extends k_Controller
{
    
    private $message = array();
    
    public $map = array('language' => 'Translation2_Frontend_Controller_Lang_Index',
                        'search' => 'Translation2_Frontend_Controller_Search');

    function GET($values = array())
    {
        
        $this->document->title = 'Translation';
        $this->document->options = array(
            $this->url('language') => 'Add language',
            $this->url('search') => 'Search for translation'
        );
        
        if(!empty($this->GET['edit_id']) && !empty($this->GET['page_id'])) {
            $values = array();
            $values['identifier'] = $this->GET['edit_id'];
            $values['page_id'] = $this->GET['page_id'];
            foreach($this->getLangs() AS $lang => $description) {
                $values['translation'][$lang] = $this->getTranslation()->get($this->GET['edit_id'], $this->GET['page_id'], $lang);
            }
        }
        
        $data['created_page_id'] = $this->getCreatedPageId();
        $data['message'] = $this->getMessages();
        $data['langs'] = $this->getLangs();
        $data['values'] = $values;
        
        $content = $this->render('Translation2/Frontend/templates/create-tpl.php', $data);
        return $this->render('Translation2/Frontend/templates/wrapper-tpl.php', $data = array('content' => $content));
    }
    
    function POST()
    {
        
        if(!empty($this->POST['new_page_id'])) {
            $page_id = $this->POST['new_page_id'];
        } elseif(!empty($this->POST['page_id']) && $this->POST['page_id'] != '<none>') {
            $page_id = $this->POST['page_id'];
        } else {
            $this->setMessage('You need to provide a pageID');
            return $this->GET();
        }
        
        if(empty($this->POST['identifier'])) {
            $this->setMessage('You need to fill in the identifier');
            return $this->GET();
        }
        
        $identifier = $this->POST['identifier'];
        
        $page = $this->getTranslation()->getPage($page_id);
        if(empty($this->POST['overwrite']) && isset($page[$identifier])) {
            $this->setMessage('The translation does already exist');
            foreach($this->getLangs() AS $lang => $description) {
                $this->setMessage(ucfirst($description).': '.$this->getTranslation()->get($identifier, $page_id, $lang), 'translation_'.$lang);
            }
            $values = $this->POST->getArrayCopy();
            $values['overwrite'] = 1;
            return $this->GET($values);
        }
        
        if(false !== ($common_page_id = $this->getCommonPageId())) {
            $page = $this->getTranslation()->getPage($common_page_id);
            if(empty($this->POST['overwrite']) && isset($page[$identifier])) {
                $this->setMessage('The translation does already exist in common');
                foreach($this->getLangs() AS $lang => $description) {
                    $this->setMessage(ucfirst($description).': '.$this->getTranslation()->get($identifier, $common_page_id, $lang), 'translation_'.$lang);
                }
                $values = $this->POST->getArrayCopy();
                $values['overwrite'] = 1;
                return $this->GET($values);
            }
        }
        
        $result = $this->getTranslationAdmin()->add($identifier, $page_id, $this->POST['translation']);
        if (PEAR::isError($result)) {
            throw new Exception($result->getMessage());
        }
        
        $message = 'Translation successfully added!<br />Identifier: '.$identifier.'<br />PageID: '.$page_id;
        foreach($this->getLangs() AS $lang => $description) {
            $message .= '<br />'.ucfirst($description).': '.$this->POST['translation'][$lang];
        }
        $this->setMessage($message);
        
        return $this->GET();
    }
    
    function getLangs()
    {
        return $this->getTranslationAdmin()->getLangs();
    }
    
    function getTranslationAdmin()
    {
        return $this->registry->get('translation_admin');
    }

    function getTranslation()
    {
        $translation = $this->registry->get('translation');
        $translation = $translation->getDecorator('DefaultText');
        return $translation;
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
    
    private function setMessage($message, $place = 'main')
    {
        $this->message[$place] = $message;
    }
    
    private function getMessages()
    {
        return $this->message;
    }
    
    public function getCommonPageId()
    {
        if(is_callable(array($this->context, 'getTranslationCommonPageId'))) {
            return $this->context->getTranslationCommonPageId();
        }
        
        return false;
    }
}

