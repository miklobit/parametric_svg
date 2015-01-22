<?php
namespace classes\template;

class XmlTemplate {
    
    protected $dom;  
    protected $xml;
    protected $mimeType;
    protected $compressionLevel; // gizp compreesion level, 0 = no compression
   
   
    function __construct() {

           $this->xml = '';
           $this->dom = new \DOMDocument();
           $this->setMimeType( "application/xml" ) ;   
           $this->setCompression( 0 );
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

    public function setCompression( $compressionLevel = 0 ) {
        $this->compressionLevel = $compressionLevel ;
    }   
    
    public function setMimeType( $mimeType ) {
        $this->mimeType = $mimeType ;
    }
    
    public function sendMimeHeader( ) {
          header('Content-type: '.$this->mimeType);
    }  
    
    public function sendEncodingHeader( ) {
          if( $this->compressionLevel > 0 ) {
            header('Content-Encoding: gzip', true);
          }
    }        
    
    public function pushXmlFile( ) {
        $this->sendEncodingHeader( );
        $this->sendMimeHeader( );
        if( $this->compressionLevel == 0 ) {
            echo $this->getXml( );
        }
        else {
            echo gzencode($this->getXml( ), $this->compressionLevel );
        }
    }
    
    
}
?>