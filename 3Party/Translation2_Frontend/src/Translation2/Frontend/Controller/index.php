<?php
class Translation2_Frontend_Controller_Index extends k_Controller
{
    public $map = array('search' => 'Translation2_Frontend_Controller_Search');

    function GET()
    {
        return '<a href="' .$this->url('search') . '">Search</a>';
    }

}