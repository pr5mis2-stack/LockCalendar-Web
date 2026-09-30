<?php
/**
 *
 *  xmlWriterClass
 *
 *  @Desc     : xml 생성
 *  @Author   : deborah
 *  @Date     : 2011. 05. 03. 오전 11:10:31
 *  @Version  :
 */
class CM_XmlWriter {
    var $xml;
    var $log_xml;
    var $indent;
    var $stack = array();
    function __construct($indent = ''){
        $this->indent = $indent;         
 		     $this->xml .='<?xml version="1.0" encoding="UTF-8"?>'."\n";
        //$this->xml = '';    
    }
    function _indent() {
        for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
            $this->xml .= $this->indent;        
        }
    }
    function push($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;
        
        foreach ($attributes as $key => $value) {
            
            $this->xml .= ' '.$key.'="'.$value.'"';            
        }
        $this->xml .= ">\n";        
        $this->stack[] = $element;
    }
    function element($element, $content, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;        
        foreach ($attributes as $key => $value) {          
          $this->xml .= ' '.$key.'="'.$value.'"';
          // $this->log_xml .= ' '.$key.'="'.$value.'"';
        } 
        /*
        $content = str_replace("<", "&lt;", $content);
        $content = str_replace(">", "&gt;", $content);
        $content = str_replace("&", "&amp;", $content);
        */
        $content = str_replace("&#8212;", "-", $content);
        $content = str_replace("&#039;","'",  $content);    
        
        $content = htmlspecialchars_decode($content,ENT_QUOTES);
        
        $this->xml .= '>'.$content.'</'.$element.'>'."\n";        
        
        // $this->xml .= '><![CDATA['.$content.']]></'.$element.'>'."\n";
         //$this->xml .= '>'.htmlspecialchars($content).'</'.$element.'>'."\n";        
    }
    function element_cdata($element, $content, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;        
        foreach ($attributes as $key => $value) {          
          $this->xml .= ' '.$key.'="'.$value.'"';
          // $this->log_xml .= ' '.$key.'="'.$value.'"';
        } 
	   	$content = str_replace("&#039;", "'", $content);                
        $content = str_replace("&", "&amp;", $content);    
        $content = str_replace("<", "&lt;", $content);
        $content = str_replace(">", "&gt;", $content);
        $content = str_replace("&", "&amp;", $content);    
        
        $this->xml .= '><![CDATA['.$content.']]></'.$element.'>'."\n";  
    }
    function emptyelement($element, $attributes = array()) {
        $this->_indent();
        $this->xml .= '<'.$element;        
        foreach ($attributes as $key => $value) {
            $this->xml .= ' '.$key.'="'.htmlentities($value).'"';            
        }
        $this->xml .= " />\n";        
    }
    function pop() {
        $element = array_pop($this->stack);
        $this->_indent();
        $this->xml .= "</$element>\n";        
    }
    function getXml() {
        return $this->xml;
    }
} 
  

?>