<?php
class Translation2_Frontend_Controller_Search extends k_Controller
{
    function GET()
    {
        $this->document->title = 'Search';
        $this->document->options = array(
            $this->url('../') => 'Back'
        );
        
        
        $data['result'] = array();
        
        if(!empty($this->GET['search'])) {
            $sql = 'SELECT * FROM core_translation_i18n WHERE id LIKE "%'.$this->GET['search'].'%"';
            foreach($this->context->getLangs() AS $lang => $description) {
                $sql .= ' OR '.$lang.' LIKE "%'.$this->GET['search'].'%"';
            }
            $mdb2 = $this->registry->get('mdb2');
            $result = $mdb2->query($sql);
            if(PEAR::isError($result)) {
                throw new Exception('Error in query', $result->getUserInfo());
            }
            $data['result'] = $result->fetchAll();
        }
        
        $data['langs'] = $this->context->getLangs();
        return $this->render('Translation2/Frontend/templates/search-tpl.php', $data);
    }

}

