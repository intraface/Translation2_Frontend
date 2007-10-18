<?php
class Translation2_Frontend_Controller_Root extends k_Dispatcher
{
    public $debug = true;
    public $map = array('translation' => 'Translation2_Frontend_Controller_Index');

    function execute()
    {
        return $this->forward('translation');
    }
}