<?php
class PEAR_Translation2_Controller_Search extends k_Controller
{
    function GET()
    {
        $translations = $this->getTranslation()->getPage(null);
        
        
        if(PEAR::isError($translations)) {
            throw new Exception('Error: '.$translations->getUserInfo());
          
        }
        $translations = array_map('utf8_decode', $translations);
    }

}

