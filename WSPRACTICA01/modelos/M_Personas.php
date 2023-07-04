<?php
    class M_Personas extends \DB\SQL\Mapper{
        public function __construct(){
            parent::__construct(\Base::instance()->get('DB'), 'persona');
        }
    }
?>