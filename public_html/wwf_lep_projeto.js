window.onload = function (){

	// VARS //

	var i,
		r,
		a,
		b,
		d,
		dur=100,
		tag,
		tag2,
		tag3,
		tag4,
		tag5,
		tag6,
		lista,
		legenda,
		conteudo,
		bt_lista,
		bt_legenda,
		telas = [],
		preloader,
		map,
		resultados,
		repositorio,
		rep,
		layer,
		layout,
		leg,
		mapOptions,
		br,
		win_w,
		win_h,
		tema,
		session,
		projeto_id,
		cookie,
		get;

	var projeto = document.getElementById('projeto');
	var conteudo_telas;
	var conteudo_tela;
	var apoio;

	var root = location.origin;
	var path = location.pathname.split('/');

	for(i=0; i<path.length-1; i++){
		root += path[i] + '/';
	}

	console.log("_root: " + root);

	get = location.href.split("?id=");

	if(get.length > 1){
		projeto_id = get[1];
	}else{
		document.location.href = "projetos.html";
	}

	var conteudos = ['SOBRE','DOCUMENTOS','DADOS','RESULTADOS'];

	var temas = [
			'#cc6666','#e26565','#ee9569','#e7b34c','#be995e',
			'#c0c05a','#90bd63','#7cba7c','#68be93','#66cccc',
			'#6699cc','#79a7d4','#75b8d9','#8585d6','#7e7ebb',
			'#7c5f99','#9473b5','#ad6bad','#b6628c','#c4567b'];


	// CORES //

	function aplicar_tema(){
		$('.resultados_lista li').hover(function(){
			if(layout != 1) $( this ).css({backgroundColor:temas[tema]})
		},function(){
			if(layout != 1) $( this ).css({backgroundColor:''})
		});
		$('.bt_item').hover(function(){
			if(layout != 1) $( this ).css({backgroundColor:temas[tema]})
		},function(){
			if(layout != 1) $( this ).css({backgroundColor:''})
		});
		$('.mapa_bt').hover(function(){
			if(this.className.indexOf('select') < 0){
				if(layout != 1) $( this ).css({backgroundColor:temas[tema]})
			}
		},function(){
			if(layout != 1) $( this ).css({backgroundColor:''})
		});
		$('.conteudo_bt').hover(function(){
			if(this.className.indexOf('select') < 0){
				if(layout != 1) $( this ).css({backgroundColor:temas[tema]})
			}
		},function(){
			if(layout != 1) $( this ).css({backgroundColor:''})
		});
		$('#erro_nome').css({backgroundColor:temas[tema]});
		$('#erro_profissao').css({backgroundColor:temas[tema]});
		$('#erro_email').css({backgroundColor:temas[tema]});
	}


	// DADOS PROJETO //

	var myRequest;
	var xml_projeto;
	var projeto_arr = [];

	if(window.XMLHttpRequest){
		myRequest = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		myRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}

	myRequest.onreadystatechange = function(){
		if(this.readyState === 4){
			xml_projeto = this.responseXML;
			projeto_arr = xml2arr (
				xml_projeto, "dados",
					["id",
					"publicado",
					"titulo",
					"lat",
					"lng",
					 "zoom",
					 "sobre",
					["resultados", "resultado", ["label","titulo","id","titulo_legenda","legenda"]],
					["documentos", "documento", ["id","publicado","titulo","autor","ano","veiculo","link","arquivo"]],
					["arquivos", "arquivo", ["id","titulo","grupo","label"]]
					]);

			// dados
			d = projeto_arr["dados"];
			d.path1 = root + "projetos/projeto" + d.id + "/";
			d.path2 = root + "repositorio/projeto" + d.id + "/";

			tag = document.createElement('div');
			tag.id = 'projeto' + d.id;
			tag.className = 'tela_projeto';

			d.repositorio = [];

			jQuery.ajax({
				url: "scan_dir.php?id=" + d.id,
				type: "GET",
				cache : false,
				dataType: "text",
				data:"string",
				success: function( data ){

					console.log("repositorio ajax:");
					console.log(data);
					repositorio = data.split(',');

					for(i=0; i<repositorio.length; i++){

						rep = {};

						repositorio[i] = repositorio[i].split(' | ');
						for(r=0; r<repositorio[i].length; r++){
							rep.arquivo = repositorio[i][0];
							rep.nome = repositorio[i][1];
							rep.ext = repositorio[i][2];
							rep.bites = repositorio[i][3];
						}

						d.repositorio.push(rep);
					}

					// map

					mapOptions = {
						center: new google.maps.LatLng(d.lat,d.lng),
						zoom: Number(d.zoom),
						mapTypeId: google.maps.MapTypeId.SATELLITE,
						panControl: false,
						mapTypeControl: false,
						streetViewControl: false,
						scrollwheel: true,
						scaleControl: true,
						overviewMapControl: false,
						rotateControl: false,
						backgroundColor: '#fff',
						scrollwheel: true,
						zoomControl: false
					};

					map = new google.maps.Map(tag, mapOptions);

					tag2 = document.createElement('div');
					tag2.className = 'projeto_bts';
					tag.appendChild(tag2);

					google.maps.event.addListener(map, 'dragstart', function() {
						fechar_lista();
						fechar_telas();
					});

					tag3 = document.createElement('div');
					tag3.id = 'zoom_in';
					tag3.className = 'mapa_bt zoom_in';
					tag3.onclick = function(){
						map.setZoom(map.getZoom() + 1);
					}
					tag2.appendChild(tag3);

					tag3 = document.createElement('div');
					tag3.id = 'zoom_out';
					tag3.className = 'mapa_bt zoom_out';
					tag3.onclick = function(){
						if(map.getZoom() > 3) map.setZoom(map.getZoom() - 1);
					}
					tag2.appendChild(tag3);

					//titulo

					tag3 = document.createElement('div');
					tag3.className = 'titulo voltar wwf mapa_bt';
					tag3.id = 'titulo';
					tag3.innerHTML = d.titulo;
					tag2.appendChild(tag3);

					tag3.onclick = function(){
						document.location.href = "projetos.html" ;
					}

					br = document.createElement('br');
					tag2.appendChild(br);

					//resultados

					bt_lista = document.createElement('div');
					bt_lista.id = 'resultado' + d.id;
					bt_lista.className = 'resultados mapa_bt';
					tag2.appendChild(bt_lista);

					bt_lista.onclick = function(){
						if(lista.visible){
							fechar_lista();
						}else{
							abrir_lista();
						}
					}

					br = document.createElement('br');
					tag2.appendChild(br);

					lista = document.createElement('ul');
					lista.id = 'resultados' + d.id;
					lista.className = 'resultados_lista';
					tag2.appendChild(lista);

					$(lista).hide();
					lista.visible = false;

					preloader = document.createElement('div');
					preloader.className = 'preloader';
					tag.appendChild(preloader);
					$(preloader).hide();

					map.resultados = [];

					for(r=0; r<d.resultados.length; r++){
						tag5 = document.createElement('li');
						tag5.id = 'resultado' + d.resultados[r].id;
						tag5.ID = d.resultados[r].id;
						tag5.titulo_legenda = d.resultados[r].titulo_legenda;
						tag5.legenda = d.resultados[r].legenda.split('|');

						tag5.lb = d.resultados[r].titulo.toUpperCase();
						tag5.innerHTML = tag5.lb;
						tag5.className = 'mapa_bt';

						lista.appendChild(tag5);
						map.resultados.push(tag5);
						tag5.onclick = function(){
							chamar_kmz(this);
						}

						layer = new google.maps.KmlLayer({
							suppressInfoWindows: true,
							preserveViewport: true,
							url:root + "repositorio/projeto" + d.id + "/" + d.resultados[r].label + ".kmz?session=" + session
						});

						google.maps.event.addListener(layer, 'status_changed', function () {
							$(preloader).stop(true).fadeOut(dur);
						});

						tag5.layer = layer;

						br = document.createElement('br');
						lista.appendChild(br);
					}

					// legenda

					bt_legenda = document.createElement('div');
					bt_legenda.className = 'legenda mapa_bt';
					bt_legenda.innerHTML = "LEGENDA";
					tag2.appendChild(bt_legenda);

					bt_legenda.onclick = function(){
						if(legenda.visible){
							fechar_legenda();
						}else{
							abrir_legenda();
						}
					}

					legenda = document.createElement('ul');
					legenda.className = 'legenda_tx scroll2';
					tag2.appendChild(legenda);

					$(legenda).hide();
					legenda.visible = false;

					// conteudo

					conteudo = document.createElement('div');
					conteudo.id = 'conteudo';
					tag2.appendChild(conteudo);

					conteudo_telas = document.createElement('div');
					conteudo_telas.id = 'conteudo_telas';
					conteudo_telas.tela_atual = 0;
					conteudo_telas.visible = true;
					$(conteudo_telas).css({maxHeight:win_h-250});
					tag2.appendChild(conteudo_telas);

					// registro user funcs

					function verifica_registro( url ){
						cookie = get_cookie("regsitro_lep");
						if( cookie != "ok" && cookie != "no" ){

							$(erro_nome).hide();
							$(erro_email).hide();
							$(erro_profissao).hide();

							registro_user.style.display = "block";
							$(registro_user).hide().fadeIn(dur);


							registro_x.onclick = function(){
								$(registro_user).stop(true).fadeOut(dur);
							}
							registro_nome.onfocus = function(){
								if(this.value == '') this.placeholder = '';
							}
							registro_nome.onblur = function(){
								if(this.value == '') this.placeholder = 'NOME';
							}
							registro_email.onfocus = function(){
								if(this.value == '') this.placeholder = '';
							}
							registro_email.onblur = function(){
								if(this.value == '') this.placeholder = 'E-MAIL';
							}
							registro_profissao.onfocus = function(){
								if(this.value == '') this.placeholder = '';
							}
							registro_profissao.onblur = function(){
								if(this.value == '') this.placeholder = 'PROFISSÃO/INSTITUIÇÃO'; 		
							}

							registro_cancel.onclick = function(){
								set_cookie("regsitro_lep", "no", 90);
								$(registro_user).fadeOut(dur);
							}

							$(registro_form).ajaxForm({
								type:'post',
								beforeSubmit: checkForm,
								success:function() {
									set_cookie("regsitro_lep", "ok", 90);
									$(registro_form).hide();
									$(registro_cancel).hide();
									$(registro_tx).html('Registro enviado. Obrigado!').hide().delay(dur*3).fadeIn(dur*3);
									$(registro_user).animate({height:145}, dur*3).delay(2000).fadeOut(dur*3);
								}
							});

						}else{

							window.open( url );

						}
					}

					for(a=0; a<4; a++){

						var tela = [],
						conteudo_tela;

						tag4 = document.createElement('div');
						tag4.className = 'conteudo_bt';
						tag4.innerHTML = conteudos[a];
						tag4.ID = a;
						conteudo.appendChild(tag4);

						tela[0] = tag4;

						tag4.onclick = function(){
							if(conteudo_telas.tela_atual == this.ID) fechar_telas();
							else abrir_tela(this.ID);
						}

						tag5 = new Image();
						tag5.src = '_layout/fechar.png';
						tag4.appendChild(tag5);

						if(a==0){
							tag4.className += ' select';
						}

						conteudo_tela = document.createElement('div');
						conteudo_tela.className = 'conteudo_tela';
						conteudo_telas.appendChild(conteudo_tela);

						tela[1] = conteudo_tela;
						telas.push(tela);

						if(a>0) $(conteudo_tela).hide();

						//sobre
						if(a==0){
							tag2 = document.createElement('div');
							tag2.className = "conteudo_titulo wwf";
							tag2.innerHTML = "SOBRE";
							conteudo_tela.appendChild(tag2);
							conteudo_tela.innerHTML += d.sobre;

							apoio = new Image();
							apoio.className = 'apoio';
							conteudo_tela.appendChild(apoio);

							//apoio
							$.get('projetos/projeto' + projeto_id + '/apoio.jpg')
							.done(function() {
								apoio.src = "projetos/projeto" + projeto_id + "/apoio.jpg";
							}).fail(function() {
								$(apoio).hide();
							})

						}

						//documentos
						if(a==1){

							tag2 = document.createElement('div');
							tag2.className = "conteudo_titulo wwf";
							tag2.innerHTML = "DOCUMENTOS";
							conteudo_tela.appendChild(tag2);

							var doc,
								item,
								bt_dw,
								bt_lk,
								item_lb,
								temp;

							for(i=0; i<d.documentos.length; i++){

								doc = d.documentos[i];

								if(doc.publicado == 1){

									item = document.createElement('div');
									item.className = 'doc_lista';
									item.id = 'item' + i;

									if(doc.arquivo != ''){
										bt_dw = document.createElement('div');
										bt_dw.className = 'bt_item item_downlaod';
										bt_dw.ID = doc.id;
										bt_dw.arquivo = doc.arquivo;
										bt_dw.onclick = function(){
											verifica_registro(root + "documentos/" + this.arquivo);
										}
										item.appendChild(bt_dw);
									}

									if(doc.link != ''){
										bt_lk = document.createElement('div');
										bt_lk.className = 'bt_item item_link';
										bt_lk.link = doc.link;
										bt_lk.onclick = function(){
											verifica_registro( this.link );
										}
										item.appendChild(bt_lk);
									}

									item_lb = document.createElement('span');
									item_lb.className = 'doc_lb2';
									temp = doc.titulo;
									temp += "<span class='sub_lb'></br>" +  doc.autor;
									if( doc.veiculo != '' ) temp += " &ndash; " + doc.veiculo;
									temp += ", " + doc.ano  + "</span>";
									item_lb.innerHTML = temp;
									item.appendChild(item_lb);

									conteudo_tela.appendChild(item);
								}
							}
						}

						//dados
						if(a==2){

							var arq,
								sbt,
								bt,
								bt_lb,
								arquivo,
								arq_lista,
								arquivo_lb,
								arquivo_lista,
								grupo_titulo,
								bt_dw,
								grupos = [[],["ALVOS DE CONSERVA&Ccedil;&Atilde;O"],
											 ["CUSTOS DE CONSERVA&Ccedil;&Atilde;O"],
											 ["ARQUIVOS DE ENTRADA MARXAN"]];

							for(i=0; i<d.arquivos.length; i++){
								arq = d.arquivos[i];
								arquivo = document.createElement('div');
								arquivo.className = 'item_lista';
								arquivo.nbts = 0;

								arquivo_lb = document.createElement('span');
								arquivo_lb.className = 'item_lb';
								arquivo_lb.innerHTML = d.arquivos[i].titulo;
								arquivo.appendChild(arquivo_lb);

								arq_lista = document.createElement('div');
								arq_lista.className = 'arq_lista';
								arq_lista.open = false;
								arquivo.lista = arq_lista;

								//console.log("repositorio:");
								//console.log(d.repositorio);

								for(r=0; r<d.repositorio.length; r++){
									rep = d.repositorio[r];

									if(rep.nome == arq.label){

										arquivo.nbts++;

										sbt = document.createElement('div');
										sbt.className = 'item_lista sbt';
										arq_lista.appendChild(sbt);

										bt_lb = document.createElement('span');
										bt_lb.className = 'item_lb';
										bt_lb.innerHTML = label_arquivo(rep.ext, rep.arquivo, rep.bites);
										sbt.appendChild(bt_lb);

										bt_dw = document.createElement('div');
										bt_dw.className = 'bt_item item_downlaod sbt';
										bt_dw.path = d.path2;
										bt_dw.arquivo = rep.arquivo;
										sbt.appendChild(bt_dw);

										bt_dw.onclick = function(){
											verifica_registro(this.path + this.arquivo, "_blank" );
										}
									}
								}

								bt = document.createElement('div');
								bt.className = 'bt_item item_open';
								bt.arquivo = arquivo;
								bt.onclick = function(){
									if(this.arquivo.lista.open){
										this.arquivo.lista.open = false;
										$(this.arquivo.lista).stop(true).animate({height:0},dur*2);
										this.className = "bt_item item_open";
									}else{
										this.arquivo.lista.open = true;
										$(this.arquivo.lista).stop(true).animate({height:this.arquivo.nbts*43 + 5},dur*2);
										this.className = "bt_item item_close";
									}
								}

								arquivo.appendChild(bt);
								grupos[Number(arq.grupo)].push(arquivo);
							}

							for(i=1; i<grupos.length; i++){
								if(grupos[i].length>1){

									grupo_titulo = document.createElement('div');
									grupo_titulo.className = "conteudo_titulo wwf";
									grupo_titulo.innerHTML = grupos[i][0];

									conteudo_tela.appendChild(grupo_titulo);

									for(b=1; b<grupos[i].length; b++){
										arquivo = grupos[i][b];

										conteudo_tela.appendChild(arquivo);
										conteudo_tela.appendChild(arquivo.lista);

									}
								}
							}
						}

						//resultados
						if(a==3){
							var resultado_cel,
								resultado_tb,
								resultado_titulo,
								rep,
								arquivo,
								arquivo_lb,
								bt_dw;

							tag2 = document.createElement('div');
							tag2.className = "conteudo_titulo wwf";
							tag2.innerHTML = "RESULTADOS";
							conteudo_tela.appendChild(tag2);
							for(i=0; i<d.resultados.length; i++){
								resultado_cel = document.createElement('div');
								resultado_cel.className = "resultado_cel";
								conteudo_tela.appendChild(resultado_cel);

								resultado_tb = document.createElement('div');
								resultado_tb.className = "resultado_tb";
								$(resultado_tb).css({backgroundImage:'url('+ d.path1 + 'tb' + d.resultados[i].id + '.jpg?session=' + session + ')'})
								resultado_cel.appendChild(resultado_tb);

								resultado_titulo = document.createElement('div');
								resultado_titulo.className = "resultado_titulo mapa_bt";
								resultado_titulo.innerHTML = d.resultados[i].titulo;
								resultado_titulo.bt_lista = map.resultados[i];
								map.resultados[i].bt_tela_resultados = resultado_titulo;
								resultado_titulo.onclick = function(){
									chamar_kmz(this.bt_lista);
								}

								resultado_cel.appendChild(resultado_titulo);

								for(r=0; r<d.repositorio.length; r++){
									rep = d.repositorio[r];
									if(rep.nome ==  d.resultados[i].label){
										arquivo = document.createElement('div');
										arquivo.className = 'item_lista';
										resultado_cel.appendChild(arquivo);

										arquivo_lb = document.createElement('span');
										arquivo_lb.className = 'item_lb';
										arquivo.appendChild(arquivo_lb);

										arquivo_lb.innerHTML = label_arquivo(rep.ext, rep.arquivo, rep.bites);

										bt_dw = document.createElement('div');
										bt_dw.className = 'bt_item item_downlaod';
										bt_dw.path = d.path2;
										bt_dw.arquivo = rep.arquivo;
										arquivo.appendChild(bt_dw);

										bt_dw.onclick = function(){
											verifica_registro(this.path + this.arquivo, "_blank" );
										}
									}
								}
							}
						}
					}

					// iniciar

					projeto.appendChild(tag);
					aplicar_tema();

					if(map.resultados[0]) chamar_kmz(map.resultados[0]);

				} // ajax success
			}); // ajax
		} // ready state
	} // complete xml


	function label_arquivo(lb, arq, bites){

		var tipo;
		var peso;

		console.log(lb + " : " + arq + " : " + bites );

		if(bites <= 1000) peso = '1KB';
		else if(bites > 1000 && bites < 1000000) peso = Math.round(bites*10/1000)/10 + ' KB';
		else if(bites > 1000000 && bites < 1000000000) peso = Math.round(bites*10/1000000)/10 + ' MB';
		else if(bites >= 1000000000 ) peso = Math.round(bites*10/1000000000)/10 + ' GB';

		//	round($size/1000, 2) + kb


		if(lb == "zip") tipo = 'SHAPEFILE';
		else if(lb == "txt") tipo = 'METADADOS';
		else tipo = lb.toUpperCase();

		return tipo + " : " + arq + " <span class='sub_lb'> ( " + peso + " )</span>";
	}

	function chamar_kmz(alvo){
		console.log("chamar kmz: " + alvo.ID );
		for(r=0; r<map.resultados.length; r++){
			d = map.resultados[r];
			if(d == alvo){
				bt_lista.innerHTML = d.lb;
				d.className = "select";
				$(preloader).fadeTo(dur,.75);
				d.layer.setMap(map);
				d.bt_tela_resultados.className = 'resultado_titulo mapa_bt select';

				legenda.innerHTML = "";

				tag = document.createElement('div');
				tag.className  = 'legenda_titulo';
				tag.innerHTML = d.titulo_legenda;
				legenda.appendChild(tag);

				for(a=0; a<d.legenda.length; a++){
					leg = d.legenda[a].split(',');
					tag = document.createElement('li');
					tag.innerHTML = leg[0];
					tag2 = document.createElement('span');
					tag2.style.backgroundColor = leg[1];
					tag.appendChild(tag2);
					legenda.appendChild(tag);
				}

			}else{
				d.layer.setMap(null);
				d.className = "mapa_bt";
				d.bt_tela_resultados.className = 'resultado_titulo mapa_bt';
			}
		}

		fechar_lista();

	}

	function abrir_lista(){
		lista.visible = true;
		$(lista).fadeIn(dur);
		$(bt_lista).css({backgroundImage:'url(_layout/icon_up2.png)'});
		fechar_legenda();
		fechar_telas();
	}

	function fechar_lista(){
		lista.visible = false;
		$(lista).fadeOut(dur);
		$(bt_lista).css({backgroundImage:'url(_layout/icon_dw2.png)'});
	}

	function abrir_tela(ID){
		for(i=0; i<4; i++){
			d = telas[i][0];
			if(i == ID){
				d.className = "conteudo_bt select";
				$( d ).css({backgroundColor:''});
				$(telas[i][1]).show();
				$(conteudo_telas).stop(true).fadeIn(dur);
				conteudo_telas.tela_atual = ID;
			}else{
				d.className = "conteudo_bt";
				$(telas[i][1]).hide();
			}
		}
		fechar_legenda();
		fechar_lista();
	}

	function fechar_telas(){
		conteudo_telas.tela_atual = -1;
		$(conteudo_telas).fadeOut(dur);
		for(i=0; i<4; i++){
			d = telas[i][0];
			d.className = "conteudo_bt";
		}
	}

	function abrir_legenda(){
		legenda.visible = true;
		$(legenda).fadeIn(dur);
		$(bt_legenda).css({backgroundImage:'url(_layout/icon_dw2.png)'});
		legenda.scrollTop = 0;
		fechar_lista();
		fechar_telas();
	}

	function fechar_legenda(){
		legenda.visible = false;
		$(legenda).fadeOut(dur);
		$(bt_legenda).css({backgroundImage:'url(_layout/icon_up2.png)', color:'#fff'});
	}


	// form

	var registro_user = document.getElementById("registro_user");
	var registro_form = document.getElementById("registro_form");
	var registro_x = document.getElementById("registro_x");
	var registro_tx = document.getElementById("registro_tx");
	var news = document.getElementById("news");
	var news_cb = document.getElementById("news_cb");

	var registro_nome = document.getElementById("registro_nome");
	var registro_email = document.getElementById("registro_email");
	var registro_profissao = document.getElementById("registro_profissao");
	var erro_nome = document.getElementById("erro_nome");
	var erro_profissao = document.getElementById("erro_profissao");
	var erro_email = document.getElementById("erro_email");

	erro_nome.onclick = function(){
		$(this).stop(true).fadeOut(dur);
	}
	erro_profissao.onclick = function(){
		$(this).stop(true).fadeOut(dur);
	}
	erro_email.onclick = function(){
		$(this).stop(true).fadeOut(dur);
	}


	function checkForm () {
		var r1 = true;
		var r2 = true;
		var r3 = true;

		if( registro_nome.value == '' ){
			r1 = false;
			$(erro_nome).stop(true).fadeIn(dur);
		}

		if( registro_profissao.value == '' ){
			r2 = false;
			$(erro_profissao).stop(true).fadeIn(dur);
		}

		if( news_cb.checked && !verifica_email(registro_email.value)){
			r3 = false;
			$(erro_email).stop(true).fadeIn(dur);
		}

		console.log(news);

		if(r1 && r2 && r3){
			return true;
		} else {
			return false;
		}
	}

	function verifica_email(email){
		if(	email.indexOf("@") < 0 ||
		  	email.indexOf(".") < 0 ||
		   	email.indexOf(".") == email.length-1 ||
		   	email.indexOf(".") == 0){
				return false
		}else{
				return true;
		}
	}

	function set_cookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}

	function get_cookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
		}
		return "";
	}


	// window


	window.onresize = resize;

	function resize(){
		win_w = $( window ).width();
		win_h = $( window ).height();

		$(conteudo_telas).css({maxHeight:win_h-200});

		if(win_w < 700 && layout !=1){
			layout = 1;
			document.body.className = "L1";
		}

		if(win_w >= 700 && layout !=2){
			layout = 2;
			document.body.className = "L2";
		}
	}

	resize();

	// XML //

	function xml2arr(_xml, obj_lb, atts){
		var arr = [];
		var id = '';
		var _id = '';
		var obj;
		var join;
		var xml;
		var _xml;

		xml = _xml.getElementsByTagName(obj_lb);

		for(var i=0; i<xml.length; i++){
			obj = {};
			if( obj_lb != 'dados' ) id = ponteiro_lista(xml,i,"id");
			for( var a=0; a<atts.length; a++ ){

				if(isArray(atts[a])){
					//_xml = sub lista de itens. ex: projetos > projeto > arquivos > arquivo
					// estrutura abaixo evita que tag 'arquivo' fora da lista 'arquivos' entre no array
					_xml = xml[i].getElementsByTagName(atts[a][0])[0].getElementsByTagName(atts[a][1]);
					obj[atts[a][0]]	= [];

					for(_i=0; _i<_xml.length; _i++){

						join = {};
						for( var b=0; b<atts[a][2].length; b++ ){  // atts
							join[atts[a][2][b]] = ponteiro_lista(_xml,_i,atts[a][2][b]);
						}

						if( atts[a][1] != 'dados' ) _id = ponteiro_lista(_xml,_i,"id");

						obj[atts[a][0]].push(join);
						obj[atts[a][0]][ atts[a][1] + _id ] = join;
					}

				}else{
					obj[atts[a]] = ponteiro_lista(xml,i,atts[a]);
				}
			}

			arr.push(obj);
			arr[obj_lb + id] = obj;
		}

		return arr;

	}

	// att
	function ponteiro_att(xml, ID, att){
		if( xml[ID] ){
			return xml[ID].getAttribute(att);
		}
	}

	// nodes
	function ponteiro_lista(xml,a,lb){ //  ponteiro que retorna conteúdo da tag com index [a] e tags internas do index [a][b]
		if(xml[a].getElementsByTagName(lb)[0]){ // se a tag estiver vazia, o firstChild = null da bug no retorno da proxima linha
			return xml[a].getElementsByTagName(lb)[0].firstChild.nodeValue;
		}
	}

	function isArray( obj ) {
		return toString.call(obj) === "[object Array]";
	};


	// load data
	session = sessionStorage.getItem("session");
	tema = sessionStorage.getItem("tema");

	if( !tema || !session || tema == null || session == null  ){

		session = Math.random() * 1000;
		tema = 0;

		sessionStorage.setItem("tema", tema );
		sessionStorage.setItem("session", session);

		console.log("tema: " + tema);
		console.log("session: " + session);
	}


	myRequest.open("GET", "projetos/projeto"+ projeto_id +"/dados.xml?session="+session, true);
	myRequest.send(null);

}
