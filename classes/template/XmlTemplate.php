<?php
namespace classes\template;

class XmlTemplate {
    
    protected $dom;  
    protected $xml;
    protected $mimeType;
   
   
    function __construct() {

           $this->xml = '';
           $this->dom = new \DOMDocument();
           $this->setMimeType( "application/xml" ) ;           
    }           
   
    public function loadFromFile(  $uri ) {
        $this->xml = file_get_contents( $uri, NULL );
        if( $this->xml != false ) {
             $this->dom->loadXML( $this->xml );
             return $this->dom ;
//             echo $this->xmlContent->saveXML();     
        }
        else {
           return false ;    
        }
    } 
    
    public function loadFromXml(  $xml, $options = 0 ) {
             $this->xml = $xml ;
             $this->dom->loadXML( $this->xml, $options );
             return $this->dom ;
    }     
    
    public function getXml( $stripDTD = false ) {
            if( $stripDTD ) {
                $this->xml = $this->dom->saveXML( $this->dom->documentElement );                
            }
            else {
                $this->xml = $this->dom->saveXML( );
            }    
            return $this->xml ;
            
    }
 
    public function getEntityList() {
            $enities = array() ;
            $dtd = $this->dom->doctype ;
            for( $i = 0 ; $i < $dtd->entities->length; $i++ ) {
                $enities[$i] = $dtd->entities->item($i)->nodeName;
            }
            return $enities ;
    }      
    
    public function decodeEntityList( $entityList = array(), $decodeDTD = false ) {
            $this->xml = $this->dom->saveXML( );
            $entities = $this->getEntityList() ;
            foreach ( $entities as $entityName ) {
                if( isset( $entityList[$entityName] )) {
                    $this->xml = str_replace( "&".$entityName.";" , $entityList[$entityName] , $this->xml );
                }
            } 
            $options =  ( $decodeDTD == false ) ? 0 : LIBXML_NOENT ;
            return  $this->loadFromXml( $this->xml , $options ) ;
             
    }
    
    public function setMimeType( $mimeType ) {
        $this->mimeType = $mimeType ;
    }
    
    public function sendMimeHeader( ) {
        $this->mimeType = $mimeType ;
    }    
    
    
}
?>