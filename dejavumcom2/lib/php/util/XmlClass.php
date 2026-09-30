<?php
/**
 *  XmlClass
 *
 *  @Desc     :
 *  @Author   : 이정수
 *  @Date     : 2011. 2. 10. 오전 10:52:36
 *  @Version  :
 *  tags
 */

class XmlClass {

	var $xmlData;	// xml내용
	var $arrData;	// array내용
	
	/**
	 *
	 *  XmlClass
	 *
	 *  @Desc      :
	 *  @Author    : 이정수
	 *  @Date      : 2011. 2. 10. 오전 11:09:06
	 *  @Return    :
	 */
	function __construct() {

	}

	/**
	 *
	 *  xmlToArray
	 *
	 *  @Desc      : DOMDocument를 이용한 xmlString => array 
	 *  @Author    : 이정수
	 *  @Date      : 2011. 2. 10. 오전 11:08:06
	 *  @param $xmlstr
	 *  @Return    :
	 */
	function xmlToArray($xmlstr) {
		$doc = new DOMDocument();
		$doc->loadXML($xmlstr);
		return $this->domnode_to_array($doc->documentElement);
	}

	/**
	 *
	 *  domnode_to_array
	 *
	 *  @Desc      :
	 *  @Author    : 이정수
	 *  @Date      : 2011. 2. 10. 오전 11:08:10
	 *  @param $node
	 *  @Return    :
	 */
	function domnode_to_array($node) {
		$output = array();
		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			case XML_ELEMENT_NODE:
				for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) {
					$child = $node->childNodes->item($i);
					$v = $this->domnode_to_array($child);
					if(isset($child->tagName)) {
						$t = $child->tagName;
						if(!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					}
					elseif($v) {
						$output = (string) $v;
					}
				}
				if(is_array($output)) {
					if($node->attributes->length) {
						$a = array();
						foreach($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string) $attrNode->value;
						}
						$output['@attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if(is_array($v) && count($v)==1 && $t!='@attributes') {
							$output[$t] = $v[0];
						}
					}
				}
				break;
		}
		return $output;
	}

	/**
	 *
	 *  arrayToXml
	 *
	 *  @Desc      :
	 *  @Author    : 이정수
	 *  @Date      : 2011. 2. 10. 오전 11:06:59
	 *  @param $data
	 *  @param $rootNodeName
	 *  @param $xml
	 *  @Return    :
	 */
	function arrayToXml($data, $rootNodeName = 'data', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set('zend.ze1_compatibility_mode', 0);
		}

		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
		}

		//new dBug($data);
		//exit;
		
		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				//$key = "unknownNode_". (string) $key;
				$key = (string) $key;
			}

			// replace anything not alpha numeric
			//$key = preg_replace('/[^a-z]/i', '', $key);

			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				XmlClass::arrayToXml($value, $rootNodeName, $node);
			}
			else
			{
				// add single node.
				//$value = htmlentities($value);
				//$value = iconv("EUC-KR", "UTF-8//IGNORE", $value);
				//$value = "&lt;![CDATA[".$value."]]&gt;";
				//<![CDATA[#### 내용파트 ]]>
				//if(preg_match("/[^0-9]/", $value))
				//	$value = "\<![CDATA[".$value."]]\>";
				$xml->addChild($key, $value);
			}

		}
		// pass back as string. or simple xml object if you want!
		return trim(str_replace("<?xml version=\"1.0\" encoding=\"utf-8\"?>", "<?xml version='1.0' encoding='utf-8'?>", preg_replace('/<[0-9]*>/', '', preg_replace('/<\/[0-9]*>/', '', $xml->asXML()))));
	}
}
?>