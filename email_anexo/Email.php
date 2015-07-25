<?php
class Email{
	var $sender;
	var $destiny;
	var $file;
	var $copy;
	var $subject;
	var $message;
	var $rn;
	public function __construct(){
		if( PATH_SEPARATOR ==';'){
			$this->rn = "\r\n"; 
		} elseif (PATH_SEPARATOR==':'){
			$this->rn = "\n";	 
		} elseif ( PATH_SEPARATOR!=';' and PATH_SEPARATOR!=':' )  {
			echo ('Esse Script Não Funcionará Corretamente!');		 
		}
	}
	/*
		Setar Arquivo
	*/
	public function setAttachment($arquivo){
		$arquivo  = $this->reArrayFiles($arquivo);
		$this->file = $arquivo;			
	}
	/*
		Recuperar Arquivo
	*/
	public function getAttachment(){
		return $this->file;	
	}
	/*
		Setar Remetente	
	*/
	public function setSender($email){
		$this->sender = $email;	
	}
	/*
		Recuperar Remetente	
	*/
	public function getSender(){
		return $this->sender;	
	}
	/*
		Setar Destinatário
	*/
	public function setDestiny($email){
		$this->destiny = $email;	
	}
	/*
		Recuperar Destinatário
	*/
	public function getDestiny(){
		return $this->destiny;	
	}
	/*
		Setar Cópia Oculta
	*/
	public function setCopy($email){
		$this->copy = $email;	
	}
	/*
		Recuperar Cópia Oculta
	*/
	public function getCopy(){
		return $this->copy;	
	}
	/*
		Recuperar Assunto
	*/
	public function getSubject(){
		return $this->subject;	
	}
	/*
		Setar Assunto
	*/
	public function setSubject($assunto){
		$this->subject= $assunto;	
	}	
	/*
		Recuperar Mensagem
	*/
	public function getBody(){
		return $this->message;	
	}
	/*
		Setar Assunto
	*/
	public function setBody($message){
		$this->message = $message;	
	}
	/*
		Enviar!
	*/
	public function send(){
		$arquivos = $this->getAttachment();
		$rn = $this->rn;
		$assunto = $this->getSubject();
		$email = $this->getDestiny();
		$email_from = $this->getSender();
		$mensagem = $this->getBody();

		if($this->checkFiles($arquivos)){				 
			$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
			$message = "--$boundary" . $rn; 
			$message .= "Content-Transfer-Encoding: 8bits" . $rn; 
			$message .= "Content-Type: text/html; charset=\"UTF-8\"" . $rn . "" . $rn;
			$message .= "$mensagem" . $rn . $rn; 			
			 
			foreach($arquivos as $arquivo):	
				//print_r($arquivo);	
				if($arquivo["size"] > 0){
					$fp = fopen($arquivo["tmp_name"],"rb"); 
					$anexo = fread($fp,filesize($arquivo["tmp_name"])); 
					$anexo = base64_encode($anexo); 
					$type = $arquivo["type"];
					fclose($fp);		
					 
					$anexo = chunk_split($anexo); 			
					$message .= "--$boundary" . $rn;	
					$message .= "Content-Type: ".$type.$rn; 	
					$message .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"" . $rn; 
					$message .= "Content-Transfer-Encoding: base64" . $rn . "" . $rn;
					$message .= "$anexo" . $rn; 
					$mens .= "--$boundary--" . $rn; 
 
					$headers = "MIME-Version: 1.0" . $rn; 
					$headers .= "From: $email_from " . $rn ; 
					$headers .= "Return-Path: $email_from " . $rn; 
					$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"" . $rn; 
					$headers .= "$boundary" . $rn; 
				}
			endforeach;
		}
		else{
			$message = "$mensagem" . $rn . $rn; 		
		}
		
		$enviado = mail($email,$assunto,$message,$headers, "-r".$email_from); 		

		if($enviado){
			return true;
		}
		else{
			return false;
		}
	}
	/*
		Reordena Array!
	*/
	public function reArrayFiles(&$file_post) {
		$file_array = array();
		$file_count = count($file_post['name']);
		$file_keys = array_keys($file_post);
	
		for ($i=0; $i<$file_count; $i++) {
			foreach ($file_keys as $key) {
				$file_array[$i][$key] = $file_post[$key][$i];
			}
		}
	
		return $file_array;
	}
	/*
		Verifica cada arquivo se possui tamanho maior do que Zero (0)
	*/
	public function checkFiles($arquivos){
		$i = 0;
		foreach($arquivos as $arquivo):			
			if($arquivo["size"] > 0){
				$i++;
			}
		endforeach;
		return $i;
	}
	
	
	public function __destruct(){
		
	}

}

?>