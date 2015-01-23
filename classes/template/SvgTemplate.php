<?php
namespace classes\template;


class SvgTemplate extends XmlTemplate {
    
    function __construct() {
           parent::__construct();
           $this->setMimeType( "image/svg+xml" ) ;   
    }       
    
}
?>