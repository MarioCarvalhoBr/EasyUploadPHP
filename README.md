# EasyUpload PHP
<strong>EasyUpload PHP - Biblioteca para facilitar o processo de upload de imagens em PHP.</strong>

<pre>
@Nome: EasyUpload PHP - Biblioteca para facilitar o processo de upload de imagens em PHP.
@Versão: 1.0.0.

@Autor: Mario de Araújo Carvalho 
@E-mail: mariodearaujocarvalho@gmail.com

@Descrição: Classe utilitária para o tratamento de Imagens com direferentes tipos e dimensões.
Além de realizar o redimensionamento automático das Imagens, afim de trabalhar com dimensões
padrões e com pouca perda de proporcionalidade.
Essa biblioteca contém diversas funcões. Entre elas:
	01: VERIFICAR SE UM DADO ARQUIVO É IMAGEM.
	02: REDIMENSIONAMENTO DAS IMAGENS.
	03: SALVAR IMAGENS NO SERVIDOR.
	04: GERAÇÃO DE NOME ÚNICO PARA AS IMAGENS.
	05. PEGAR AS EXTENSÕES DAS IMAGENS.
	06. ACEITA 4 TIPOS DE IMAGENS: 'gif', 'jpeg', 'jpg', 'png';
	07: CONVERTE AS IMAGENS PARA O SEU TIPO DE ORIGEM OU PARA UM TIPO PADRÃO CASO DESEJADO
	

</pre>

<b>ABAIXO segue uma breve DOCUMENTAÇÃO sobre a utilização da biblioteca.</b>

 ```php
		/*Exemplo de utilização da biblioteca*/
	
		<?php
	include_once("EasyUploadPHP.class.php");

	define('TAMANHO_MAXIMO', (2 * 1024 * 1024));
	$caminho = "_uploads/default.png";

	if(isset ($_POST['Salvar'])){

	if (!empty($_FILES['imagem'])){
		 $upload = new Upload($_FILES['imagem'], 1265, 700, "_uploads/");
		 $result =  $upload->salvar();

		 if($result == 'nao_moveu'){
			 echo('<script>window.alert("Erro ao mover imagem para o servidor!");</script>');
		 }else if($result == 'nao_e_imagem'){
			 echo('<script>window.alert("Não é imagem!");</script>');
		 }else{
			 $caminho = $result;
		 }

	}else{
		 echo('<script>window.alert("Esse arquivo não é uma imagem!");</script>');
	}
}

?>
  ```
  
  </br>
  <b>Seja livre para contribuir com o projeto, usando-o e melhorando.</b>
  </br>
  </br>

<b>Seu site usa essa biblioteca? Você pode promovê-lo aqui! Basta enviar o seu pedido que serei feliz em divulgar.</b>

#Desenvolvido por<br>
Nome: Mário de Araújo Carvalho<br> 
E-mail: mariodearaujocarvalho@gmail.com<br>
GitHub: https://github.com/MarioDeAraujoCarvalho<br>
Título: UserDataCollectorWEB
<br>

#Licença
``` 
        Copyright 2017 Mário de Araújo Carvalho
 
  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at
 
      http://www.apache.org/licenses/LICENSE-2.0
 
  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License.

````

<a href="https://github.com/MarioDeAraujoCarvalho/EasyUploadPHP/blob/master/LICENSE" target="_blank">Mais detalhes sobre a licença</a>
