<?php
$listagem  = listagem("imagens/", 'Diretorio');
$impressao = impressao($listagem);
echo'<pre>';print_r($impressao);exit;

function impressao($listagem)
{
	global $data;
	$listagem = json_decode($listagem, true);
	foreach($listagem as $diretorio){
		$nomeDiretorio = $diretorio["diretorio"];
		
		if(!empty(($diretorio["arquivos"]))){
			$data[$nomeDiretorio] = $diretorio["arquivos"];
		}
		
		foreach($diretorio["subdiretorios"] as $sub){
			if(!empty($sub)){
				impressao($sub, "sub");
			}
		}
	}
	return $data;
}

function listagem($diretorio, $type)
{   
    $path  = $diretorio;
    $files = scandir($path);
	$dados = array(
		"diretorio" => $path,
		"subdiretorios" => array(),
		"arquivos" => array()
	);
	
    for($i = 2; $i< count($files); $i++){
        
        if(is_dir($path.$files[$i])){
            $dados["subdiretorios"][] = listagem($path.$files[$i].'/','Subdiretorio');
        }else{
			$dados["arquivos"][] = $path.$files[$i];
		}       
    }
	return json_encode(array($dados));
}
?>