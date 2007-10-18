<?php

class Translation2_Frontend_Controller_Root extends k_Dispatcher
{
    public $map = array('translation' => 'Translation2_Frontend_Controller_Index');

    function GET()
    {
        return 'root';
    }
}