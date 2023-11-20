<?php
$list  = listAll("images/", 'Dir');
$print = printAll($list);
echo'<pre>';print_r($print);exit;

function printAll($list)
{
	global $data;
	$list = json_decode($list, true);
	foreach($list as $dir){
		$nomeDiretorio = $dir["dir"];
		
		if(!empty(($dir["files"]))){
			$data[$nomeDiretorio] = $dir["files"];
		}
		
		foreach($dir["sub"] as $sub){
			if(!empty($sub)){
				printAll($sub);
			}
		}
	}
	return $data;
}

function listAll($dir, $type)
{   
    $path  = $dir;
    $files = scandir($path);
	$dados = array(
		"dir" => $path,
		"sub" => array(),
		"files" => array()
	);
	
    for($i = 2; $i< count($files); $i++){
        
        if(is_dir($path.$files[$i])){
            $dados["sub"][] = listAll($path.$files[$i].'/','Sub');
        }else{
			$dados["files"][] = $path.$files[$i];
		}       
    }
	return json_encode(array($dados));
}
?>