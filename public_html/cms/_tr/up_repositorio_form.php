<style> 
	.up_file_form{ width:100%; clear:both; height:40px; background:#f0f0f0; padding:12px; margin-bottom:2px; border-radius:3px; position:relative; }
	.up_file_form input{ width:35%; float:left}
	.progress { position:absolute;  top:8px; right:10px; width:60%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; background:#fff;    }
	.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
	.percent { position:absolute;  top:5px; width:100%; text-align:center; font-size:10px;} 

</style> 

<script>  

	$( document ).ready (function() {  

		function location(msg){ 
			var loc = window.location.href.split("?");   
			var gets_out = ""; 
			if(loc.length > 1){
				var gets = loc[1].split("&");

				for(var g=0; g<gets.length; g++){ 
					if(gets[g].substring(0,3) != "msg"){ 
						gets_out += gets[g] + "&";
					}
				}
			} 
			window.location.replace(loc[0] + "?" + gets_out + msg);  
		}
		
		// sequential upload

		var lista = document.getElementById('lista').value.split(","); 

		function funcs(){
			$('.single').unbind( "change" );
			$('.single').change( function(){
				console.log(this);
				if( this.value != ''){
					this.style.color = "#8cbf8c";
					// verifica arquivos existentes
					if( lista.indexOf(this.files[0]['name']) >= 0 ){ 
						var ok = confirm("SUBSTITUIR ARQUIVO " + this.files[0]['name'] + " ?"); 
						if(!ok){
							this.style.color = "";
							this.value = ''; 
						} 
					}
				}else{
					this.style.color = "";
				}

			});  

			$('.up_file_form').unbind( "ajaxForm" );
			$('.up_file_form').ajaxForm({
				beforeSend: function() {
					console.log("beforeSend");
					percentVal = '0%';
					bar.width(percentVal)
					percent.html(percentVal);
				},
				uploadProgress: function(event, position, total, percentComplete) {
					percentVal = percentComplete + '%';
					console.log("uploadProgress [" + percentVal + "]");
					bar.width(percentVal)
					percent.html(percentVal);
				},
				success: function() {
					console.log("success");
					percentVal = '100%';
					bar.width(percentVal)
					percent.html(percentVal);
				},
				complete: function() { 
					console.log("complete");
					setTimeout(function(){
						next_upload();
					},1000);
				},
				error: function(jqXHR, textStatus, errorThrown) { 
					console.log("erro: " + textStatus);
					setTimeout(function(){
						next_upload();
					},1000);
				} 
			});

		}
		
		funcs();

		var pos = 0; 
		var form;
		var percentVal
		var bar;
		var percent;

		function next_upload(){
			if(pos < n_campos){
				pos++;

				console.log("----------------------");
				console.log("INICIANDO UPLOAD " + pos);

				bar = $('#bar' + pos);
				percent = $('#percent' + pos);
				arquivo = $('#input' + pos);
				form = $('#form' + pos);

				console.log("arquivo: " + arquivo.val());

				if(arquivo.val() != ''){
					console.log(">>SUBMIT!")
					form.submit(); 
				}else{
					next_upload();
				}	
			}else{
				console.log("========================");
				location("msg_ok=UPLOAD COMPLETO");
				pos = 0;
			}	
		} 

		// add
		var trava = false;

		var bt_add = $('#bt_add');
		var campos = $('#campos');
		var n_campos = 1;	

		var campo;

		$(bt_add).click(function() {

			if(!trava){
				n_campos ++;

				campo = "<form id='form"+n_campos+"' class='up_file_form' enctype='multipart/form-data' action='php/projeto_repositorio_up.php' method='post'>";
				campo += "<input lista='all' id='input"+n_campos+"' type='file' name='arquivo' class='single'>";
				campo += "<div id='progress"+n_campos+"' class='progress'>";
				campo += "<div id='bar"+n_campos+"' class='bar'></div>";
				campo += "<div id='percent"+n_campos+"' class='percent'>0%</div>";
				campo += "</div>";
				campo += "</form>";

				campos.append(campo);

				// atribui funcs a todos os forms
				funcs();
			}

		});	

		// enviar

		var enviar = $('#enviar');

		$(enviar).click(function() {
			if(!trava){
				console.log("START");
				$(bt_add).css({opacity:.3});
				$(enviar).css({opacity:.3});
				trava = true;
				next_upload();
			}
		});	

	});

</script>