<?php
class Translation2_Frontend_Controller_Index extends k_Component
{
    private $message = array();
    protected $template;
    protected $translation;
    protected $mdb2;

    function __construct(MDB2_Driver_Common $mdb2, k_TemplateFactory $template, Translation2_Admin $translation)
    {
        $this->mdb2 = $mdb2;
        $this->template = $template;
        $this->translation = $translation;
    }

    function renderHtml()
    {
        return 'intentionally left blank - could show the translation';
    }

    function renderHtmlEdit()
    {
        $data['created_page_id'] = $this->getCreatedPageId();
        $data['message'] = $this->getMessages();
        $data['langs'] = $this->getLangs();
        $data['values'] = $values;

        $tpl = $this->template->create('Translation2/Frontend/templates/create');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        if($this->body('new_page_id')) {
            $page_id = $this->POST['new_page_id'];
        } elseif($this->body('page_id') && $this->body('page_id') != '<none>') {
            $page_id = $this->body('page_id');
        } else {
            $this->setMessage('You need to provide a pageID');
            return $this->renderHtml();
        }

        if($this->body('identifier')) {
            $this->setMessage('You need to fill in the identifier');
            return $this->renderHtml();
        }

        $identifier = $this->body('identifier');

        $page = $this->getTranslation()->getPage($page_id);
        if($this->body('overwrite') && isset($page[$identifier])) {
            $this->setMessage('The translation already exists');
            foreach($this->getLangs() AS $lang => $description) {
                $this->setMessage(ucfirst($description).': '.$this->getTranslation()->get($identifier, $page_id, $lang), 'translation_'.$lang);
            }
            $values = $this->body();
            $values['overwrite'] = 1;
            return $this->renderHtml($values);
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
            $translation = $this->body('translation');
            $message .= '<br />'.ucfirst($description).': '.$translation[$lang];
        }
        $this->setMessage($message);

        return $this->renderHtml();
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
