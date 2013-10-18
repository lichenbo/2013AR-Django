<?php 
// author: Chenbo Li
	date_default_timezone_set('Asia/Shanghai');
	$date = date('m/d/Y h:i:s a');
// table-driven
	$form_fields = $_REQUEST;
	$keyword_list = array('AND','OR','=','WHERE','SELECT','>','<','\'');
// generate string write to txt.
	$form_string = "$date";
	foreach ($form_fields as $field_key => $field_value) {
		$field_value = trim(preg_replace('/\s+/',' ',$field_value));
		$form_string = $form_string. "\t$field_value";
	}
	$form_string = $form_string. "\r\n";
	$form_string = htmlspecialchars($form_string);

	mail('lichenbo1949@gmail.com,J22Melody@gmail.com,fuyunguan@gmail.com','New applicant for lilystudioer',$form_string);
// partial function to split the strings in the array
	$arr_explode_fields = array_map(
			function($str){return explode(" ",$str);},
			array_values($form_fields));
// merge all arrays using reduce, producing a keyword array
	$arr_user_input = array_reduce($arr_explode_fields,"array_merge",array());
// decide whether the user-input contains keywords
	foreach ($arr_user_input as $user_input) {
		if (in_array(strtoupper($user_input), $keyword_list)) {
			header('Content-Type: text/html');
?>
<html>
	<head>
		<title>Query failed</title>
	</head>
	<body>
		<h2>Query failed: ERROR: syntax error at or near "" at character 56 in /www/site/b.php on line 121.</h2>
	</body>
</html>
<?php
// write injection statement into hack.txt
// you can view it at hack.php
			$file = fopen("hack.txt","a") or exit("Unable to open file!");
			fputs($file,$form_string);
			fclose($file);
			exit;
			die();
		}
	}

// view the information in view.php
	$file = fopen("table.txt","a") or exit("Unable to open file!");
	fputs($file,$form_string);
	fclose($file);
	header('Çontent-Type: application/json');
	$arr_json["success"] = true;
	echo json_encode($arr_json);
