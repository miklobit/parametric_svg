<?php
  use classes\template\SvgTemplate as SvgTemplate; 
  require_once "./bootstrap.php" ;
//  header('Content-type: text/plain');
  
  ini_set('display_errors', '1');

  $template = new SvgTemplate(); 
  $template->loadFromFile("./svg/template1.svg");
  $template->setCompression( 0 ) ;  
//  var_dump( $template->getEntityList() );
//  var_dump( $_GET );
  
  $entityList = array( "circle_cy" => "150" ,
                       "circle_fill" => "gray" , 
                       "circle_stroke" => "blue" 
  );
  $template->decodeEntityList( $entityList , true );
  $template->pushXmlFile( );
?>