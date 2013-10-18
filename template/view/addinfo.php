<?php 
	$number = $_REQUEST['number'];
	$name = $_REQUEST['name'];
	$content = str_replace("<br />","\n",$_REQUEST['content']);
	$content = htmlspecialchars($content);
	file_put_contents("details/$number/$name",$content) or exit("Cannot open $name");
	echo '信息保存成功！';
