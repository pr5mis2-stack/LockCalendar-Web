<?php
    /**
 *  index.php
 *  @Desc      : index
 *  @Author    : SUYA
 *  @Date      : 2012. 03. 07. 오전 11:03:57
 *  @param 	 
 *  @Return
 */

if (!empty($_SESSION['dejavu_id']))
	echo "<META http-equiv=\"refresh\" content=\"0; url=/maker/main.php\">";
else
	echo "<META http-equiv=\"refresh\" content=\"0; url=/main/main.php\">";
?>