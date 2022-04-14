<?php
$filename = 'arquivos/nfe.xml';
$arq = fopen($filename,'r+');
$cont = 0;
while(!feof($arq)){
	$linha = fgets($arq);
	$limite = strlen($linha);
	if($cont == 2) echo $linha."<br>";
	$cont++;
}



/*while(!feof($arq)){
	$linha = fgets($arq);
	$limite = strlen($linha);

	
	$novalinha = htmlentities($linha);

//	$novalinha = htmlspecialchars($linha,ENT_COMPAT);
	$novalinha = str_replace('&rdquo;','"',$novalinha);
	$novalinha = str_replace('?','"',$novalinha);	
//	$fw = fwrite($arq,$linha);
//	$novalinha = str_replace('&ldquo','\"',$novalinha);
//	echo addcslashes($novalinha,"\"")."<br>";
	echo $novalinha."<br>";
}
*/
	

fclose($arq);

/*







$DOMDocument = new DOMDocument( '1.0', 'UTF-8' );
$DOMDocument->preserveWhiteSpace = false;
$DOMDocument->load( $filename);
$products = $DOMDocument->getElementsByTagName( 'det' );

foreach( $products as $product )
{
    printf( '<strong>Produto:</strong> %s<br/>
             <strong>Valor:</strong> %01.2f<br/>', 
            $product->getElementsByTagName( 'xProd' )->item( 0 )->nodeValue,
            $product->getElementsByTagName( 'vUnCom' )->item( 0 )->nodeValue
    );
}
*/
?>