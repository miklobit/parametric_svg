<?php
  use classes\template\XmlTemplate as XmlTemplate; 
  require_once "./bootstrap.php" ;
//  header('Content-type: text/plain');
  
  ini_set('display_errors', '1');

  $template = new XmlTemplate(); 
  $template->loadFromFile("./svg/template.svg");
  $template->setMimeType("image/svg+xml");
  $template->setCompression( 0 ) ;  
//  var_dump( $template->getEntityList() );
//  var_dump( $_GET );
  
  $entityList = array( "circle_cy" => "150" ,
                       "circle_fill" => "yellow"  
  );
  $template->decodeEntityList( $entityList , true );
  $template->pushXmlFile( );
?>