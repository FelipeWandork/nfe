<?php
ini_set("default_charset","utf-8");
date_default_timezone_set("America/Sao_Paulo");

class DataHora {
	private $data;
	private $hora;
	
	private function pegarDataHora(){
		$socket = fsockopen('udp://pool.ntp.br', 123, $err_no, $err_str, 1);
		if ($socket)
		{
			if (fwrite($socket, chr(bindec('00'.sprintf('%03d', decbin(3)).'011')).str_repeat(chr(0x0), 39).pack('N', time()).pack("N", 0)))
			{
				stream_set_timeout($socket, 1);
//				$unpack0 = unpack("N12", fread($socket, 48));
				$data = date('Y-m-d');
				$hora = date('H:i:s');
				$this->setData($data);
				$this->setHora($hora);
			}
			fclose($socket);
		}
	}
	
	public function setData($data){
		$this->data = $data;
	}
	
	public function getData(){
		$this->pegarDataHora();
		return $this->data;
	}
	
	public function setHora($hora){
		$this->hora = $hora;
	}
	
	public function getHora(){
		$this->pegarDataHora();
		return $this->hora;
	}

}
