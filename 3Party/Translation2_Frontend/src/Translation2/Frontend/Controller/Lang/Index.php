<?php
class Translation2_Frontend_Controller_Lang_Index extends k_Component
{
    public $map = array('create' => 'Translation2_Frontend_Controller_Lang_Create');
    protected $translation;
    protected $template;

    function __construct(Translation2_Admin $translation, k_TemplateFactory $template)
    {
        $this->translation = $translation;
        $this->template = $template;
    }

    function renderHtml()
    {
        $data = array(
            'langs' => $this->context->getTranslation()->getLangs()
        );

        $tpl = $this->template->create(dirname(__FILE__) . '/../../templates/languages');
        return $tpl->render($this, $data);
    }

    function renderHtmlCreate()
    {
        $tpl = $this->template->create(dirname(__FILE__) . '/../../templates/languages-edit');
        return $tpl->render($this, $data);
    }

    function postForm()
    {
        $this->translation->addLang($this->body());
    }

}

