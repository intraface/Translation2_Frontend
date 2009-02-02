<?php
class PEAR_Translation2_Controller_Search extends k_Controller
{
    function GET()
    {
        $db = $this->registry->get('db_sql');
        return $this->render(dirname(__FILE__) . '/../tpl/search-tpl.php', array('db' => $db));
    }

}

