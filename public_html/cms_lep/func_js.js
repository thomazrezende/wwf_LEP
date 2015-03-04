
window.onload = function(){  
	$('#mensagem').delay(2000).fadeOut(1000);   
} 

function excluir(ref,destino){ // cria o alert com o texto e redireciona para o php que fara a exclusao.
		var confirma = confirm("Confirma a exclusão de "+ ref +" ?");
		if (confirma){
			window.location = destino;
		}
	}
	
function criar(ref,destino){ // cria o alert com o texto e redireciona para o php que fara a exclusao.
		var nome = prompt("CRIAR "+ref);
		if (nome!=null && nome!=""){
			window.location = destino+"?criar="+nome;
		}
	}
	
function troca_senha(destino){
	var confirma = confirm("Confirma renovação automática de senha?");
		if (confirma){
			window.location = destino;
		}
	}
	
function hDiv(h){
	document.getElementById('lista').style.height=h+'px';
	}
	
function recarrega(){
	document.location.reload(true);	
	}
			