<?php
  use classes\template\XmlTemplate as XmlTemplate; 
  require_once "./bootstrap.php" ;
  header('Content-type: text/plain');
  
  ini_set('display_errors', '1');

  $template = new XmlTemplate(); 
  $template->loadFromFile("./svg/template.svg");
//  var_dump( $template->getEntityList() );
//  var_dump( $_GET );
  
  $entityList = array( "circle_cy" => "300" );
  $template->decodeEntityList( $entityList , true );
  echo $template->getXml( true ) ;
?>