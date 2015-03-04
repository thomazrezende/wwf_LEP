<?php ############################################################################ conexão 
	 
	function conectar(){ 
		
		$host="localhost";
		$user="root";
		$senha="root";
		$base_dados="wwf_lep";
		
		/*
		$host="";
		$user="";
		$senha="";
		$base_dados=""; 
		*/
		
		@$conexao=mysql_connect($host,$user,$senha) or die("n&atilde;o conectou"); // faz a conexão (faz a ligação) @ mostra apenas a mensagam do or die 
		mysql_select_db($base_dados,$conexao) or die("BD n&atilde;o localizada");// função pronta para conectar ao BD. segundo parâmetro retorna 1 - indica que conexão será usada para esse acesso;
		mysql_set_charset('utf8',$conexao); 
		mysql_query("SET NAMES 'utf8';", $conexao);
		mysql_query("SET CHARACTER SET 'utf8';", $conexao); 
	} 
	
	/* 
	sql para tabela log
	
	CREATE TABLE IF NOT EXISTS `logs` (
	  `id` int(5) NOT NULL auto_increment,
	  `ip` varchar(20) NOT NULL,
	  `data` date NOT NULL,
	  `hora` varchar(8) NOT NULL,
	  `browser` varchar(255) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; 
	
	senha padrão 
	31b57706df0c90626981f6c4d71fedd94c2438d104d71614a72b2447f9235884d97ec588a0bbc694a3f1b031e070c39d547e0db8df568572b4eebf0cc583061eb4f13c32
	
	*/

	function registra_log($path){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		$data = date("Y-m-d");
		$hora = date("h:i:s");
		$browser = $_SERVER['HTTP_USER_AGENT'];
		
		$sql = "INSERT INTO logs ( ip, data, hora, browser ) VALUES ( '".$ip."', '".$data."', '".$hora."', '".$browser."')";
		$inserir = mysql_query($sql);
		
		if($inserir){
			$sql_log="SELECT * FROM logs ORDER BY id DESC";
			$consult=mysql_query($sql_log);
			
			$log = fopen($path."/acessos_adm.txt", "w");
			$conteudo = "Logs de entrada no admin\r\n";
			
			//Para cada registro que tiver 
			while($result=mysql_fetch_assoc($consult)) { 
		 
				 //Pegamos o valor de cada registro 
				 $ip = utf8_encode($result["ip"]);
				 $data = utf8_encode($result["data"]); 
				 $hora = utf8_encode($result["hora"]); 
				 $browser = utf8_encode($result["browser"]); 
			 
				 //Guardamos na variavel $conteudo as tags e os valores do xml 
				 $conteudo .= "--------------------------\r\n";
				 $conteudo .= "data: ".$data."\r\n";
				 $conteudo .= "hora: ".$hora."\r\n";
				 $conteudo .= "IP: ".$ip."\r\n";
				 $conteudo .= "browser: ".$browser."\r\n";
			  
			} 
			
			fwrite($log, $conteudo);
			 
			//Fechando o arquivo 
			fclose($log); 
		}
		
	}

?>
