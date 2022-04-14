<?php
$filename = 'arquivos/nfc.xml';

$xml = simplexml_load_file($filename);

echo $xml->infNFe->ide->cUF;


/*$DOMDocument = new DOMDocument( '1.0', 'UTF-8' );
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