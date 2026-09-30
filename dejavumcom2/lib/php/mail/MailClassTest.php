<?php
require_once(__DIR__ . "/activeMailLib.php");
$action=false;
$result=false;
$from=false;
$fromname=false;
$to=false;
$cc=false;
$bcc=false;
$priority=0;
$receipt=false;
$mailtype=false;
$charset=false;
$encoding=false;
$disp=false;
$addressvalidation=false;
$servervalidation=false;
$subj="";
$body="";
$maxFileSize=300000;
extract($_POST);
if ($action=="send"){
	$email=new activeMailLib($mailtype);
	if ($addressvalidation && (!$from || $from=="")) $result="Please type your email";
	elseif ($addressvalidation && (!$to || $to=="")) $result="Please type a receiver";
	elseif ($addressvalidation && !$email->checkAddress($from)) $result="Your email seems to be invalid";
	elseif ($addressvalidation && !$email->checkAddress($to)) $result="This email seems to be invalid: ".$to;
	elseif ($addressvalidation && $cc && $cc!="" && $email->checkAddress($cc)==false) $result="This email seems to be invalid: ".$cc;
	elseif ($addressvalidation && $bcc && $bcc!="" && $email->checkAddress($bcc)==false) $result="This email seems to be invalid: ".$bcc;
	else{
		if ($servervalidation) $email->enableServerValidation();
		$email->From($from,$fromname);
		$email->To($to);
		$email->Cc($cc);
		$email->Bcc($bcc);
		if ($priority>0) $email->Priority($priority);
		if ($receipt) $email->Receipt();
		$email->Subject($subj);
		$email->Message($body,$charset,$encoding);
		if (isset($_FILES['att'])) $email->Attachment($_FILES['att']['tmp_name'],$_FILES['att']['name'],$maxFileSize,$disp);
		$email->Send();
		if (!$email->isSent($to)) $result="An internal error occured. The email was not sent";
		else{
			$result="The email was sent";
			$from=false;
			$fromname=false;
			$to=false;
			$cc=false;
			$bcc=false;
			$priority=0;
			$receipt=false;
			$mailtype=false;
			$charset=false;
			$encoding=false;
			$disp=false;
			$addressvalidation=false;
			$servervalidation=false;
			$subj="";
			$body="";
		}
	}
}
elseif ($action=="raw"){
	$email=new activeMailLib($mailtype);
	$email->From($from,$fromname);
	$email->To($to);
	$email->Cc($cc);
	$email->Bcc($bcc);
	if ($priority>0) $email->Priority($priority);
	if ($receipt) $email->Receipt();
	$email->Subject($subj);
	$email->Message($body,$charset,$encoding);
	if (isset($_FILES['att'])) $email->Attachment($_FILES['att']['tmp_name'],$_FILES['att']['name'],$maxFileSize,$disp);
	$result=$email->getRawData();
}
?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>activeMailLib Test</title>
<style type="text/css">
<!--
body {
	font-family: Helvetica, Tahoma, Arial, sans-serif;
	font-size: 12px;
	font-weight: normal;
}

.header {
	font-size: 20px;
	font-weight: bold;
}

.result {
	font-size: 14px;
	font-weight: normal;
	color: #000099;
}

.mailtable {
	border-style: outset;
	border-width: 1px;
	background-color: #eeeeee;
}
-->
</style>
</head>
<body>
<form method="post" action="test.php" enctype="multipart/form-data"">
<table class="mailtable">
	<tr>
		<td align="left" colspan="2" class="header">activeMailLib Test</td>
	</tr>
	<tr>
		<td align="right">From:</td>
		<td><input type="text" name="from" size="30"
			value="<?php echo $from; ?>" /> Name: <input type="text"
			name="fromname" size="30" value="<?php echo $fromname; ?>" /></td>
	</tr>
	<tr>
		<td align="right">To:</td>
		<td><input type="text" name="to" size="30" value="<?php echo $to; ?>" /></td>
	</tr>
	<tr>
		<td align="right">CC:</td>
		<td><input type="text" name="cc" size="30" value="<?php echo $cc; ?>" /></td>
	</tr>
	<tr>
		<td align="right">BCC:</td>
		<td><input type="text" name="bcc" size="30"
			value="<?php echo $bcc; ?>" /></td>
	</tr>
	<tr>
		<td align="right">Priority:</td>
		<td><select name="priority">
			<option value="0"
			<?php if ($priority==0) echo " selected=\"selected\""; ?>>Not set</option>
			<option value="1"
			<?php if ($priority==1) echo " selected=\"selected\""; ?>>Highest</option>
			<option value="2"
			<?php if ($priority==2) echo " selected=\"selected\""; ?>>High</option>
			<option value="3"
			<?php if ($priority==3) echo " selected=\"selected\""; ?>>Normal</option>
			<option value="4"
			<?php if ($priority==4) echo " selected=\"selected\""; ?>>Low</option>
			<option value="5"
			<?php if ($priority==5) echo " selected=\"selected\""; ?>>Lowest</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Receipt:</td>
		<td><input type="checkbox" name="receipt"
		<?php if ($receipt) echo "checked=\"checked\""; ?> /></td>
	</tr>
	<tr>
		<td align="right">Type:</td>
		<td><input type="radio" name="mailtype" value="plain"
		<?php if (!$mailtype || $mailtype=="plain") echo " checked=\"checked\""; ?> />Text
		<input type="radio" name="mailtype" value="html"
		<?php if ($mailtype=="html") echo " checked=\"checked\""; ?> />HTML</td>
	</tr>
	<tr>
		<td align="right">Charset:</td>
		<td><select name="charset">
			<option value="iso-8859-1"
			<?php if (!$charset || $charset=="iso-8859-1") echo " selected=\"selected\""; ?>>ISO-8859-1</option>
			<option value="iso-8859-7"
			<?php if ($charset=="iso-8859-7") echo " selected=\"selected\""; ?>>ISO-8859-7</option>
			<option value="iso-8859-5"
			<?php if ($charset=="iso-8859-5") echo " selected=\"selected\""; ?>>ISO-8859-5</option>
			<option value="UTF-8"
			<?php if ($charset=="UTF-8") echo " selected=\"selected\""; ?>>UTF-8</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Encoding:</td>
		<td><select name="encoding">
			<option value="quoted-printable"
			<?php if (!$encoding || $encoding=="quoted-printable") echo " selected=\"selected\""; ?>>quoted-printable</option>
			<option value="8bit"
			<?php if ($encoding=="8bit") echo " selected=\"selected\""; ?>>8bit</option>
			<option value="7bit"
			<?php if ($encoding=="7bit") echo " selected=\"selected\""; ?>>7bit</option>
			<option value="binary"
			<?php if ($encoding=="binary") echo " selected=\"selected\""; ?>>binary</option>
			<option value="base64"
			<?php if ($encoding=="base64") echo " selected=\"selected\""; ?>>base64</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Subject:</td>
		<td><input type="text" name="subj" size="80"
			value="<?php echo $subj; ?>" /></td>
	</tr>
	<tr>
		<td align="right" valign="top">Message:</td>
		<td><textarea name="body" cols="80" rows="12"><?php echo $body; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Attachment:</td>
		<td><input type="hidden" name="MAX_FILES_SIZE"
			value="<?php echo $maxFileSize; ?>" /><input type="file" name="att"
			size="50" maxlength="<?php echo $maxFileSize; ?>" /> (encoding:
		base64)</td>
	</tr>
	<tr>
		<td align="right">Disposition:</td>
		<td><input type="radio" name="disp" value="attachment"
		<?php if (!$disp || $disp=="attachment") echo " checked=\"checked\""; ?> />attachment
		<input type="radio" name="disp" value="inline"
		<?php if ($disp=="inline") echo " checked=\"checked\""; ?> />inline</td>
	</tr>
	<tr>
		<td align="right">Action:</td>
		<td><input type="radio" name="action" value="raw"
		<?php if (!$action || $action=="raw") echo " checked=\"checked\""; ?> />View
		E-mail`s raw data <input type="radio" name="action" value="send"
		<?php if ($action=="send") echo " checked=\"checked\""; ?> />Send the
		E-mail with <input type="checkbox" name="addressvalidation"
			checked="checked" /> Address Validation and <input type="checkbox"
			name="servervalidation"
			<?php if ($servervalidation) echo "checked=\"checked\""; ?> />
		Mailserver Validation</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="reset" value="RESET" /> <input type="submit"
			value="PROCCED" /></td>
	</tr>
</table>
</form>
<div class="result"><?php echo $result; ?></div>
</body>
</html>
