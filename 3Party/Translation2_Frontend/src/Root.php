<?php
class Root extends k_Dispatcher
{
    public $map = array('translation' => 'PEAR_Translation2_Controller_Index');

    function GET()
    {
        return get_class($this) . ' intentionally left blank';
    }

    function execute()
    {
        return $this->forward('translation');
    }

}