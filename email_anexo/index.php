<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Enviar Email com Anexo</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
<?
	include("Email.php");
	//Caso os arquivos sejam vários arquivos
	set_time_limit(0);	
	if(isset($_POST["send"])){
		extract($_POST);
		$email = new Email();
			$email->setAttachment($_FILES["arquivo"]);
			$email->setSender($remetente);
			$email->setDestiny($destinatario);
			$email->setCopy($copia);
			$email->setSubject($assunto);
			$email->setBody($mensagem);
		$check = $email->send();
		if($check){
			echo "<script>alert('Email enviado com Sucesso!');</script>";
		}
		else{
			echo "<script>alert('Houve um erro ao processar seu pedido!');</script>";
		}
	}
?>
<h3>Thiago Paz  - www.programador.me </h3>
<a href="https://github.com/ThiagoVieiraPaz/" target="new"><img src="http://programador.me/public/images/bt_git.png"></a>
<h1>Enviar email com Anexo!</h1>
<hr>
<div class="col-md-5">
<form action="" method="post" enctype="multipart/form-data">
 <div class="form-group">
    <label for="remetente">Remetente</label>
    <input name="remetente" type="email" required="required" class="form-control" id="remetente" placeholder="Email Remetente" value="thiagopaz@thiagopaz.com.br">
 </div>

<div class="form-group">
    <label for="destinatario">Destinatário</label>
    <input name="destinatario" type="email" required="required" class="form-control" id="destinatario" placeholder="Email Destinatário" value="programadorpaz@gmail.com">
 </div>
 
<div class="form-group">
    <label for="copia">Cópia Oculta</label>
    <input name="copia" type="email" class="form-control" id="copia" placeholder="Cópia Oculta" value="contato@programador.me">
 </div>
 
 <div class="form-group">
    <label for="assunto">Assunto</label>
    <input name="assunto" type="text" class="form-control" id="assunto" placeholder="Assunto" value="Teste de Assunto">
 </div>
 
 <div class="form-group">
    <label for="Mensagem">Mensagem</label>
    <textarea name="mensagem" class="form-control" id="mensagem" placeholder="Mensagem">Olá Teste de Mensagem</textarea>
 </div>
 <div class="form-group">
    <label for="arquivo">Arquivo</label>
    <input name="arquivo[]" type="file" id="arquivo">
    <p class="help-block">Arquivos de qualquer Tipo.</p>
  </div>
  <div class="form-group">
    <label for="arquivo">Arquivo</label>
    <input type="file" id="arquivo" name="arquivo[]">
    <p class="help-block">Arquivos de qualquer Tipo.</p>
  </div>
  <!-- Quantos Quiser :) 
   <div class="form-group">
    <label for="arquivo">Arquivo</label>
    <input type="file" id="arquivo" name="arquivo[]">
    <p class="help-block">Arquivos de qualquer Tipo.</p>
  </div>
  -->
 <button type="submit" class="btn btn-default" name="send" value="enviar">Enviar</button>
</form>
</div>
</body>
</html>