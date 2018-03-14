<?php
    /**
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
*/

	class Upload{
		/*Atributos necessários para o tratamento das IMAGENS na classe.*/
		
		private $arquivo;// ARRAY do arquivo que será tratado como IMAGEM ou não.
		private $altura; // NOVA altura das IMAGENS.
		private $largura;// NOVA altura das IMAGENS.
		private $pasta;	 // Pasta no servidor para armazenar as IMAGENS.

		/*Contrutor da Classe, que recebe os atributos necessários para o tratamento das IMAGENS e armazena nas variáveis acima.*/
		function __construct($arquivo, $altura, $largura, $pasta){
			$this->arquivo = $arquivo;
			$this->altura  = $altura;
			$this->largura = $largura;
			$this->pasta   = $pasta;
		}
		
		/*Essa função é responsável por recuperar a extenção dos arquivos passados e retorna-lá.*/
		/*Para criar sempre IMAGENS de um tipo UNICO basta alterar o tipo de retorno para a exenção de IMAGENS da preferência.*/
		private function getExtensao() {
			
			$nomeDoArquivoExendido = explode('.', $this->arquivo['name']);//Pega o Array do Arquivo: Ex: Praia.JPG
			$extencao = end($nomeDoArquivoExendido); //Pega o final do nome, ou seja a exetenção. Ex: JPG
			return strtolower($extencao); //retorna a extensao 
        }
		
		/*Essa função é responsável por verificar se o arquivo passado é uma IMAGEM ou Não, e se o tipo coresponde as tipos suportados.*/
		/*Retorna um valor booleano para inicar a validade do Arquivo.*/
		private function ehImagem($extensao){
			$extensoesSuportadas = array('gif', 'jpeg', 'jpg', 'png'); //Extenções Suportadas
			if (in_array($extensao, $extensoesSuportadas)){
				return true;	
			}else{
				return false;
			}	
		}
		
		
		/*Essa função é responsável por redimensionar a IMAGEM passada para um valor de dimensões padrões. */
		//Largura, Altura, Tipo/Extenção, Localização da IMAGEM original
		private function redimensionar($larguraDaImagem, $alturaDaImagem, $tipo, $localizacaoDaImagem){
			
			//Setando os valores padrões da NOVA IMAGEM.
			$novaLargura = 1600;
			$novaAltura = 540;
			
			//Cria uma nova IMAGEM segundo a sua Extenção com os novos valores das DIMENÇÕES.
			//$novaImagem = imagecreatetruecolor($novaLargura, $novaAltura);
			
			$novaImagem = @imagecreatetruecolor($novaLargura, $novaAltura);
			//$background_color = imagecolorallocate($novaImagem, 0, 0, 0); // 
			//$text_color = imagecolorallocate($novaImagem, 233, 14, 91);
			//imagestring($novaImagem, 1, 5, 5,  "A Simple Text String", $text_color);
			
			switch ($tipo){
				case 1:	// gif
					$origem = imagecreatefromgif($localizacaoDaImagem);
					imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0,
					$novaLargura, $novaAltura, $larguraDaImagem, $alturaDaImagem);
					imagegif($novaImagem, $localizacaoDaImagem);
					break;
				case 2:	// jpg
					$origem = imagecreatefromjpeg($localizacaoDaImagem);
					imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0,
					$novaLargura, $novaAltura, $larguraDaImagem, $alturaDaImagem);
					imagejpeg($novaImagem, $localizacaoDaImagem);
					break;
				case 3:	// png
					$origem = imagecreatefrompng($localizacaoDaImagem);
					imagecopyresampled($novaImagem, $origem, 0, 0, 0, 0,
					$novaLargura, $novaAltura, $larguraDaImagem, $alturaDaImagem);
					imagepng($novaImagem, $localizacaoDaImagem);
					break;
			}
			
			//Destrói as Imagens Temporárias CRIADAS da Memória do Servidor.
			imagedestroy($novaImagem);
			imagedestroy($origem);
		}
		
		/*Essa função é responsável por SALVAR a Imagem de forma adequada baseada nas funções da classe*/
		public function salvar(){	
		
			$extensao = $this->getExtensao();//.png
			
			//Gera um nome único e concatena com a exentão do arquivo. Ex: NomeUnico7778c85d64.JPG
			$novo_nome = $this->gerarNomeUnico() . '.' . $extensao;
			//Gera a Localização que a IMAGEM ficara baseado no nome da pasta passado. Ex: //fotos/NomeUnico7778c85d64.JPG
			$destino = $this->pasta . $novo_nome;
			
			//Tenta mover o arquivo para a Localização criada acima.
			if (! move_uploaded_file($this->arquivo['tmp_name'], $destino)){
				
				//Caso não consiga mover o arquivo.
				return "nao_moveu";
			}else{
				
				//Caso consiga mover o arquivo.
				if ($this->ehImagem($extensao)){//Verifica se o arquivo passado é uma IMAGEM.												
					
					//Recupera a largura, altura, tipo e atributo da IMAGEM.
					list($largura, $altura, $tipo, $atributo) = getimagesize($destino);

					//REDIMENSIONA a Nova Imagem e Armazena na pasta do servidor que foi passada por parametro.
					$this->redimensionar($largura, $altura, $tipo, $destino);
					
					//Retorna o destino da Imagem criada e guardada no servidor: Ex: //fotos/NomeUnico7778c85d64.JPG
					return $destino;
					
				}else{
					//Caso o arquivo passado não seja uma IMAGEM, ele destrói o mesmo do servidor e retorna um aviso de erro.
					unlink($destino);
					return "nao_e_imagem";
				}
			}
			
		}
		public function gerarNomeUnico(){
			//** Essa função gera um nome único baseado no tempo e na criptografia MD5.
			$now = DateTime::createFromFormat('U.u', microtime(true));
			
			//Variáveis únicas.
			$nome_1 = time();
			$nome_2 = $now->format('YmdHisu');
			$nome_3 = md5(uniqid(rand(), true));
			
			//Criação do nome único da imagem: Deve ser concatenado segundo desejado.
			//Recomenda-se que se use o padrão abaixo.
			//OBS: Começe pelo nome do seu site.
			$nome_unico = 'MyAplicationImage'.$nome_2.''.$nome_3.''.$nome_1;
			
			return $nome_unico;
			
		}
						
	}
?>
