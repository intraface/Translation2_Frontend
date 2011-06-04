<?php
class Translation2_Frontend_Controller_Index extends k_Component
{
    protected $message = array();
    protected $map = array('language' => 'Translation2_Frontend_Controller_Lang_Index');
    protected $template;
    protected $translation;
    protected $mdb2;
    protected $values = array();

    function __construct(MDB2_Driver_Common $mdb2, k_TemplateFactory $template, Translation2_Admin $translation)
    {
        $this->mdb2 = $mdb2;
        $this->template = $template;
        $this->translation = $translation;
    }

    function map($name)
    {
        if (isset($this->map[$name])) {
            return $this->map[$name];
        }

        return 'Translation2_Frontend_Controller_Show';
    }

    function renderHtml()
    {
        $data['result'] = array();

        if ($this->query('search')) {
            $sql = 'SELECT * FROM core_translation_i18n WHERE id LIKE "%'.$this->query('search').'%"';
            foreach($this->getLangs() AS $lang => $description) {
                $sql .= ' OR '.$lang.' LIKE "%'.$this->query('search').'%"';
            }
            $result = $this->mdb2->query($sql);
            if (PEAR::isError($result)) {
                throw new Exception('Error in query: ' . $result->getUserInfo());
            }
            $data['result'] = $result->fetchAll();
        }

        $data['langs'] = $this->getLangs();

        $tpl = $this->template->create('Translation2/Frontend/templates/search');
        return $tpl->render($this, $data);
    }

    function renderHtmlCreate()
    {
        $values = array();
        $values['identifier'] = $this->query('edit_id');
        $values['page_id'] = $this->query('page_id');
        foreach($this->getLangs() AS $lang => $description) {
            $values['translation'][$lang] = $this->translation->get($this->query('edit_id'), $this->query('page_id'), $lang);
        }

        $data['created_page_id'] = $this->getCreatedPageId();
        $data['message'] = $this->getMessages();
        $data['langs'] = $this->getLangs();
        $data['values'] = $values;

        $tpl = $this->template->create('Translation2/Frontend/templates/create');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        if ($this->body('new_page_id')) {
            $page_id = $this->body('new_page_id');
        } elseif($this->body('page_id') && $this->body('page_id') != '<none>') {
            $page_id = $this->body('page_id');
        } else {
            $this->setMessage('You need to provide a pageID');
            return $this->render();
        }

        if(!$this->body('identifier')) {
            $this->setMessage('You need to fill in the identifier');
            return $this->render();
        }

        $identifier = $this->body('identifier');

        $page = $this->getTranslation()->getPage($page_id);
        if($this->body('overwrite') && isset($page[$identifier])) {
            $this->setMessage('The translation does already exist');
            foreach($this->getLangs() AS $lang => $description) {
                $this->setMessage(ucfirst($description).': '.$this->getTranslation()->get($identifier, $page_id, $lang), 'translation_'.$lang);
            }
            $this->values = $this->body();
            $this->values['overwrite'] = 1;
            return $this->render();
        }

        if(false !== ($common_page_id = $this->getCommonPageId())) {
            $page = $this->getTranslation()->getPage($common_page_id);
            if (PEAR::isError($page)) {
                throw new Exception($page->getMessage());
            }
            if(!$this->body('overwrite') && isset($page[$identifier])) {
                $this->setMessage('The translation does already exist in common');
                foreach($this->getLangs() AS $lang => $description) {
                    $this->setMessage(ucfirst($description).': '.$this->getTranslation()->get($identifier, $common_page_id, $lang), 'translation_'.$lang);
                }
                $this->values = $this->body();
                $this->values['overwrite'] = 1;
                return $this->render();
            }
        }

        $result = $this->getTranslationAdmin()->add($identifier, $page_id, $this->body('translation'));
        if (PEAR::isError($result)) {
            throw new Exception($result->getMessage());
        }

        $message = 'Translation successfully added!<br />Identifier: '.$identifier.'<br />PageID: '.$page_id;
        foreach($this->getLangs() AS $lang => $description) {
            $translation = $this->body('translation');
            $message .= '<br />'.ucfirst($description).': '.$translation[$lang];
        }
        $this->setMessage($message);

        return new k_SeeOther($this->url($identifier, array('flare' => $message)));
    }

    function getLangs()
    {
        return $this->translation->getLangs();
    }

    function getTranslation()
    {
        $translation = $this->translation->getDecorator('DefaultText');
        return $translation;
    }

    function getCreatedPageId()
    {
        $created_page_id = $this->translation->getPageNames();
        $created_page_id = array_filter($created_page_id);
        if(count($created_page_id) == 0) $created_page_id[] = '<none>';
        return $created_page_id;
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
