// JavaScript Document
window.onload = function() {

        ///////////////////////////////////////////////////////////////////////////////////////// VARS
        /*
        mapa z-index
        1: polygons selecionado (todos)
        2: principais_polygons
        3: macro_polygons
        4: meso_polygons
        5: micro_polygons
        6: aps_polygons *
        7: ucs_polygons
        8: tis_polygons
        */

        var i;
        var d;
        var a;
        var b;
        var val;

        var branco = "#fff";
        var preto = "#333";
        var vermelho = "#c12b2b";
        var cinza = "#ccc";

        var min_zoom = 4;
        var max_zoom = 13;
        var zoom_at = 4;
        var nivel_selecao = 'bh';

        var lista_itens_h;

        var itm;
        var itm2;
        var olho;

        var dur = 300, // default duration for animations
            in_out = "easeInOutQuart",
            _out = "easeOutQuart",
            in_ = "easeInQuart";

        var map;

        var map_types;
        var tipos;
        var map_ok = false;

        var xml;

        var bacia_polygons = [];
        var principais_polygons = [];
        var macro_polygons = [];
        var meso_polygons = [];
        var micro_polygons = [];

        var uc_polygons = [];
        var ucs_polygons = [];

        var ap_polygons = [];
        var aps_polygons = [];

        var ti_polygons = [];
        var tis_polygons = [];

        var uh_places = [];
        var pj_places = [];

        var layer;

        var layers_map = {
            "bh": [bacia_polygons, principais_polygons, macro_polygons, meso_polygons, micro_polygons],
            "uc": [uc_polygons, ucs_polygons],
            "ap": [ap_polygons, aps_polygons],
            "ti": [ti_polygons, tis_polygons],
            "uh": [null, uh_places],
            "pj": [null, pj_places]
        }

        var mapa_zi = [
            null, // 0
            null, // 1: polygon selecionado
            principais_polygons, // 2
            macro_polygons, // 3
            meso_polygons, // 4
            micro_polygons, // 5
            aps_polygons, // 6
            ucs_polygons, // 7
            tis_polygons // 8
        ];

        ///////////////////////////////////////////////////////////////////////////////////////// OBJETOS

        function get(id) {
            return document.getElementById(id);
        }

        function reg(id) {
            window[id] = get(id);
        }

        reg('topo');
        reg('logout');
        reg('user_lb');

        reg('lista');
        reg('lista_cont');
        lista.aberto = false;
        reg('bt_lista');
        reg('bt_camadas');
        reg('painel_select');

        reg('lista_itens');
        lista_itens.aberto = false;

        reg('lista_camadas');
        reg('camadas_cont');
        reg('lista_bh');
        reg('lista_ap');
        reg('lista_ti');
        reg('lista_uc');
        reg('lista_pj');
        reg('lista_no');

        reg('dash');
        dash.aberto = false;
        reg('dash_topo');
        reg('dash_titulo');
        reg('dash_voltar');
        reg('dash_cont');

        reg('tipo');
        reg('zoom_in');
        reg('zoom_out');

        reg('preloader');
        reg('alerta');
        reg('alerta_tx');
        reg('alerta_ok');

        reg('mapa');
        reg('bt_bacias');
        reg('bt_areas');
        reg('nivel1');
        reg('nivel2');
        reg('nivel3');
        reg('nivel4');
        reg('nivel5');

        nivel1.codigo = 'bh';
        nivel2.codigo = 'ap';
        nivel3.codigo = 'uc';
        nivel4.codigo = 'ti';
        nivel5.codigo = 'no';

        var niveis = [nivel1, nivel2, nivel3, nivel4, nivel5];

        /////////////////////////////////////////////////////////////////////////////////////////  FUNCOES

        $(logout).on('click', function(){
            document.location.href = '../cms/php/logar.php?sessao=false';
        });

        // alerta

        $(alerta).hide();

        $(alerta_ok).on('click', function(){
            $(alerta).fadeOut(dur);
        });

        function alertar(tx){
            $(alerta_tx).html(tx);
            $(alerta).fadeIn(dur);
        }

        // NIVEL //

        function selecionar_nivel(cod) {
            var cor;
            if (dash.aberto) fechar_dash();
            nivel_selecao = cod;
            for (i in niveis) {
                cor = menu.camadas[i].cor;
                if (cod == 'no') cor = '#333';
                if (niveis[i].codigo == cod) {
                    $(niveis[i]).animate({
                        borderTopWidth: 4,
                        color: cor,
                        borderTopColor: cor
                    }, 100);
                } else {
                    $(niveis[i]).animate({
                        borderTopWidth: 0,
                        color: '#999',
                        borderTopColor: ''
                    }, 100);
                }
            }

            //lista itens
            for (a = 1; a <= 5; a++) {
                itm = get('lista_item' + a);
                if (itm.cod != cod) {
                    $(itm).removeClass('selected');
                    $(itm.cont).hide();
                } else {
                    $(itm).addClass('selected');
                    if (itm.cod != 'no') cor = menu.camadas[itm.cod].cor;
                    else cor = '#333';
                    $(painel_select).html(itm.innerHTML).css({
                        color: cor
                    });
                    $(itm.cont).show();
                }
            }

            fechar_lista_itens();

            // clickable
            for (i in layers_map) {
                if (i != 'pj' && i != 'uh') {
                    if (i == cod) {
                        for (a in layers_map[i]) unlock_all(layers_map[i][a]);
                    } else {
                        for (a in layers_map[i]) lock_all(layers_map[i][a]);
                    }
                }
            }
        }

        // CAMADAS //

        function ativar_camada(camada) {
            camada.d.ativo = true;
            $(camada.olho).css({
                backgroundColor: camada.d.cor
            })
            verifica_camada(camada.d);
        }

        function desativar_camada(camada) {
            camada.d.ativo = false;
            $(camada.olho).css({
                backgroundColor: '#e6e6e6'
            })
            verifica_camada(camada.d);
        }

        function verifica_camada(d) {
            if (d.ativo) { // on
                if ( d.codigo != 'no' ) { // fixas on
                    if( layers_map[d.codigo][1].length == 0 ){ // se não tiver carregado o mapa completo desse cod, carregue
                        bd_select(null, d.codigo, false, true);
                    }else{ // se já tiver carregado, mostre
                        for (i = 0; i < layers_map[d.codigo].length; i++) {
                            show_all(layers_map[d.codigo][i]);
                        }
                    }
                } else { // extras on
                    d.kmz.setMap(map);
                }
            } else { // off
                if (d.codigo != 'no') { // fixas off
                    for (i = 0; i < layers_map[d.codigo].length; i++) {
                        hide_all(layers_map[d.codigo][i]);
                    } // extras off
                } else {
                    d.kmz.setMap(null);
                }
            }
        }


        function hide_all(arr) {
            for (a in arr) {
                arr[a].setMap(null);
            }
        }

        function show_all(arr) {
            for (a in arr) {
                arr[a].setMap(map);
            }
        }

        function lock_all(arr) {
            for (a in arr) {
                arr[a].setOptions({
                    clickable: false
                });
            }
        }

        function unlock_all(arr) {
            for (a in arr) {
                arr[a].setOptions({
                    clickable: true
                });
            }
        }

        // LISTA //

        $(bt_lista).on('click', function() {
            if (lista.aberto && lista.tela == 'lista') {
                fechar_lista();
            } else {
                abrir_lista();
            }
        });

        $(bt_camadas).on('click', function() {
            if (lista.aberto && lista.tela == 'camadas') {
                fechar_lista();
            } else {
                abrir_camadas();
            }
        });

        function abrir_lista() {
            lista.tela = 'lista';
            lista.aberto = true;
            $(bt_lista).css({
                backgroundImage: 'url(layout/fechar_lista.png)'
            })
            $(bt_camadas).css({
                backgroundImage: 'url(layout/camadas.png)'
            })
            $(lista).animate({
                left: 0
            }, dur, in_out);
            $(camadas_cont).hide();
            $(lista_itens).show();
            $(lista_cont).show();
            $(painel_select).show();
        }

        function abrir_camadas() {
            lista.tela = 'camadas';
            lista.aberto = true;
            $(bt_camadas).css({
                backgroundImage: 'url(layout/fechar_lista.png)'
            })
            $(bt_lista).css({
                backgroundImage: 'url(layout/lista.png)'
            })
            $(lista).animate({
                left: 0
            }, dur, in_out);
            $(camadas_cont).show();
            $(lista_itens).hide();
            $(lista_cont).hide();
            $(painel_select).hide();
        }

        function fechar_lista() {
            lista.aberto = false;
            $(bt_lista).css({
                backgroundImage: 'url(layout/lista.png)'
            })
            $(bt_camadas).css({
                backgroundImage: 'url(layout/camadas.png)'
            })
            $(lista).animate({
                left: -400
            }, dur, in_out);
            if (lista_itens.aberto) fechar_lista_itens();
        }

        $(painel_select).on('click', function() {
            if (lista_itens.aberto) {
                fechar_lista_itens();
            } else {
                abrir_lista_itens();
            }
        });

        lista_itens_h = 180;

        function abrir_lista_itens() {
            lista_itens.aberto = true;
            painel_select.className = 'painel_topo aberto';
            $(lista_itens).show().animate({
                height: lista_itens_h
            }, dur, in_out);
            $(lista_cont).animate({
                bottom: -1 * lista_itens_h
            }, dur, in_out);
        }

        function fechar_lista_itens() {
            lista_itens.aberto = false;
            $(lista_itens).animate({
                height: 0
            }, dur, in_out, function() {
                painel_select.className = 'painel_topo';
                $(lista_itens).hide();
            });
            $(lista_cont).animate({
                bottom: 0
            }, dur, in_out);
        }

        $(lista_cont).on('mouseenter', function() {
            if (lista_itens.aberto) fechar_lista_itens();
        });

        for (i = 1; i <= 5; i++) {
            itm = get('lista_item' + i);
            itm.ID = i;
            itm.cod = itm.getAttribute('cod');
            itm.cont = get('painel_cont' + i);

            itm.onclick = function() {
                if (dash.aberto) fechar_dash();
                selecionar_nivel(this.cod);
            }
        }


        // DASBOARD //

        function bh_select(id, layer, fit) {

            var file = 'php_tools/bh_select.php?id=' + id;
            console.log(file);

            $(preloader).show();

            $.post(
                    file,
                    null,
                    function(data) {

						// reset locais
			            verifica_locais(false, false);

                        // bacia selecionada
                        if (id) {
                            if (bacia_polygons[0]) reset_layer(bacia_polygons);
                            bacia_polygons[0] = new google.maps.Polygon({
                                paths: draw_polygons(data.bacia.coords),
                                fillColor: menu.camadas['bh'].cor,
                                strokeWeight: 0,
                                fillOpacity: 0.3,
                                zIndex: 1,
                                clickable: false,
                                map: map
                            });

							if(fit){
								map.fitBounds(bacia_polygons[0].getBounds());
							}

                            if (data.bacia.tipo != "principal") {
                                $(dash_voltar).show();
                                $(dash_topo).css({
                                    width: 327
                                });

                                if (data.bacia.tipo == "macro") {
                                    dash_voltar.id_voltar = data.bacia.principal_id;
                                    dash_voltar.layer_voltar = macro_polygons;
                                }
                                if (data.bacia.tipo == "meso") {
                                    dash_voltar.id_voltar = data.bacia.macro_id;
                                    dash_voltar.layer_voltar = meso_polygons;
                                }
                                if (data.bacia.tipo == "micro") {
                                    dash_voltar.id_voltar = data.bacia.meso_id;
                                    dash_voltar.layer_voltar = micro_polygons;
                                }
                            } else {
                                $(dash_voltar).hide();
                                $(dash_topo).css({
                                    width: ''
                                });
                            }

                            // dados

                            var dash_titulo = data.bacia.principal.toUpperCase() + ' ' + data.bacia.tipo + ':' + id;

                            dados_dash(dash_titulo, data.bacia, menu.camadas['bh'].cor);
                            abrir_dash();

                        }

                        // subdivisoes
                        if (data.bacias.length > 0) {

                            var zi;
                            if (layer == principais_polygons) zi = 2;
                            if (layer == macro_polygons) {
                                zi = 3;
                                reset_layer(macro_polygons);
                                reset_layer(meso_polygons);
                                reset_layer(micro_polygons);
                            }
                            if (layer == meso_polygons) {
                                zi = 4;
                                reset_layer(meso_polygons);
                                reset_layer(micro_polygons);
                            }
                            if (layer == micro_polygons) {
                                zi = 5;
                                reset_layer(micro_polygons);
                            }

                            for (i in data.bacias) {
                                layer[i] = new google.maps.Polygon({
                                    paths: draw_polygons(data.bacias[i].coords),
                                    strokeColor: menu.camadas['bh'].cor,
                                    strokeWeight: 1.2,
                                    fillOpacity: 0,
                                    zIndex: zi,
                                    map: map,
                                    clickable: true,
                                });

                                layer[i].id = data.bacias[i].id;
                                layer[i].principal = data.bacias[i].principal;
                                layer[i].principal_id = data.bacias[i].principal_id;
                                layer[i].tipo = data.bacias[i].tipo;
                                layer[i].macro_id = data.bacias[i].macro_id;
                                layer[i].meso_id = data.bacias[i].meso_id;
                                layer[i].micro_id = data.bacias[i].micro_id;

                                google.maps.event.addListener(layer[i], 'click', function(event) {
                                    if (this.tipo == 'principal' && nivel_selecao == 'bh') bh_select(this.id, macro_polygons, false);
                                    if (this.tipo == 'macro' && nivel_selecao == 'bh') bh_select(this.id, meso_polygons, false);
                                    if (this.tipo == 'meso' && nivel_selecao == 'bh') bh_select(this.id, micro_polygons, false);
                                    if (this.tipo == 'micro' && nivel_selecao == 'bh') bh_select(this.id, false, false);
                                });
                            }
                        }

                        $(preloader).hide();

                    },
                    "json"
                )
                .fail(function(xhr, textStatus, errorThrown) {
                    console.log("error " + textStatus + " : " + errorThrown);
                });
        }

        function dados_dash(tit, dt, cor) {

            dash_titulo.innerHTML = tit;

            var dados_arr = dt.dados.split(',');
            var dados_grupos = dt.grupos.split(',');
            var dados_colunas = dt.colunas.split(',');

            var titulo_div = "";
            var titulo;
            var grupos = [];
            var grupo = {};
            var div;

            dash_cont.innerHTML = '';

            for (i = 2; i < dados_arr.length; i++) {

                if (dados_grupos[i] != '') {

                    grupo = {};

                    titulo = dados_grupos[i].split(':');
                    grupo.titulo = titulo[0];
                    if (titulo[1]) grupo.tipo = titulo[1].trim();
                    if (titulo[2]) grupo.max = Number(titulo[2]);
                    else grupo.max = false;

                    if (dados_arr[i] != '') {
                        grupo.colunas = [dados_colunas[i]];
                        grupo.dados = [dados_arr[i]];
                    }

                    grupos.push(grupo);

                } else {

                    if (dados_arr[i] != '') {
                        grupo.colunas.push(dados_colunas[i]);
                        grupo.dados.push(dados_arr[i]);
                    }
                }
            }

            for (i in grupos) {

                grupo = grupos[i];

                // titulo
                div = document.createElement('div');
                div.className = 'titulo';
                if (i > 0) div.className += ' titulo_div';
                div.innerHTML = grupo.titulo;
                grupo.escala = grupo.titulo.split(/\(|\)/)[1];
                dash_cont.appendChild(div);

                if (grupo.tipo) { // grafico

                    div = document.createElement('div');
                    div.id = 'chart' + i;
                    div.className = 'grafico';
                    dash_cont.appendChild(div);

                    var chart_data = [grupo.titulo];
                    for (b in grupo.dados) chart_data.push(grupo.dados[b])
                    grupo.escala = grupo.titulo.split(/\(|\)/)[1];

                    var chart_width = chart_data.length * 50;

                    var chart = c3.generate({
                        bindto: '#chart' + i,
                        size: {
                            height: 200,
                            width: chart_width
                        },
                        tooltip: {
                            contents: function (d) {
                                return "<div id='tooltip' style='background:"+cor+"'>" + d[0].value + '</div>';
                              }
                        },
                        padding: {
                            left: 40,
                            bottom: 10
                        },
                        color: {
                            pattern: [cor]
                        },
                        data: {
                            columns: [
                                chart_data
                            ],
                            type: grupo.tipo
                        },
                        legend: {
                            show: false
                        },
                        axis: {
                            x: {
                                type: 'category',
                                categories: grupo.colunas
                            },
                            y: {
                                max: grupo.max,
                                min: 0,
                                padding: {
                                    top: 0,
                                    bottom: 2
                                }
                                // ,
                                // label: {
                                //     text: grupo.escala,
                                //     position: 'outer-top'
                                // }
                            }
                        }
                    });

                } else { // dado

                    for (a in grupo.dados) {
                        div = document.createElement('div');
                        div.className = 'dado';
                        div.innerHTML += grupo.dados[a];
                        if (grupo.escala) div.innerHTML += ' ' + grupo.escala;
                        div.innerHTML += ' ' + grupo.colunas[a];
                        dash_cont.appendChild(div);
                    }
                }
            }
        }

        function grafico(dt, tp, id) {
            var chart_div = document.createElement('div');
            chart_div.id = 'chart' + id;
            chart_div.className = 'grafico';
            dash_cont.appendChild(chart_div);

            setTimeout(function() {
                var chart = c3.generate({
                    bindto: '#chart' + id,
                    data: {
                        columns: dt,
                        type: tp
                    }
                });
            }, 100);
        }

        function bd_select(id, cod, fit, nivel) {

            var file = 'php_tools/bd_select.php?id=' + id + '&cod=' + cod;
            console.log(file);

            $(preloader).show();

            $.post(
                    file,
                    null,
                    function(data) {

                        $(preloader).hide();

                        reset_map();

                        // item selecionado
                        if (id) {

                            if (data.selecao.tipo == 'area') {

                                layer = layers_map[cod][0];

                                if (layer[0]) reset_layer(layer);
                                layer[0] = new google.maps.Polygon({
                                    paths: draw_polygons(data.selecao.coords),
                                    fillColor: menu.camadas[cod].cor,
                                    strokeWeight: 0,
                                    fillOpacity: 0.3,
                                    zIndex: 1,
                                    clickable: false,
                                    map: map
                                });

								if(fit){
									map.fitBounds(layer[0].getBounds());
								}


                            } else {

                                verifica_locais(id, cod);

                            }

                            // dados

                            dados_dash(cod, data.selecao, menu.camadas[cod].cor);
                            abrir_dash();

                        } else { // itens no

                            layer = layers_map[cod][1];

                            for (i in data.mapa) {

                                if (data.mapa[i].tipo == 'area') {

                                    layer[i] = new google.maps.Polygon({
                                        paths: draw_polygons(data.mapa[i].coords),
                                        strokeColor: menu.camadas[cod].cor,
                                        strokeWeight: 1.2,
                                        fillOpacity: 0,
                                        zIndex: 7,
                                        map: map,
                                        clickable: false,
                                    });

                                    layer[i].id = data.mapa[i].id;
                                    layer[i].cod = cod;

                                    google.maps.event.addListener(layer[i], 'click', function(event) {
                                        if (nivel_selecao == this.cod) bd_select(this.id, this.cod, false, false);
                                    });

                                } else {

                                    layer[i] = new google.maps.Marker({
                                        position: place_marker(data.mapa[i].coords),
                                        icon: pinSymbol(menu.camadas[cod].cor, 1.2),
                                        map: map
                                    });

                                    layer[i].id = data.mapa[i].id;
                                    layer[i].cod = cod;

                                    layer[i].addListener('click', function() {
                                        bd_select(this.id, this.cod, false, false)
                                    });
                                }
                            }
                        }

                        if(nivel) selecionar_nivel( cod );

                    },
                    "json"
                )
                .fail(function(xhr, textStatus, errorThrown) {
                    console.log("error " + textStatus + " : " + errorThrown);
                });
        }

        function verifica_locais(id, cod) {
            var place;
            for (a in layers_map['uh'][1]) {
                place = layers_map['uh'][1][a];
                if (place.id == id && place.cod == cod) {
                    place.setIcon(pinSymbol(menu.camadas['uh'].cor, 1.5));
                } else {
                    place.setIcon(pinSymbol(menu.camadas['uh'].cor, 1.2));
                }
            }
            for (a in layers_map['pj'][1]) {
                place = layers_map['pj'][1][a];
                if (place.id == id && place.cod == cod) {
                    place.setIcon(pinSymbol(menu.camadas['pj'].cor, 1.5));
                } else {
                    place.setIcon(pinSymbol(menu.camadas['pj'].cor, 1.2));
                }
            }
        }

        function pinSymbol(color, scale) {
            return {
                path: 'M0-20c-3.9,0-7,3.1-7,7C-7-6.3,0,0,0,0s7-6.3,7-13C7-16.9,3.9-20,0-20z',
                fillColor: color,
                fillOpacity: 1,
                strokeWeight: 0,
                scale: scale,
            };
        }

        $(dash_voltar).on('click', function() {
            if (!menu.camadas.bh.ativo) ativar_camada(menu.camadas.bh.itm);
            bh_select(this.id_voltar, this.layer_voltar, false);
        })

        function reset_layer(layer) {
            for (i in layer) {
                layer[i].setMap(null);
                layer[i].setPaths([]);
            }
        }

        function place_marker(coords) {
            var coord = coords.split(',');
            return new google.maps.LatLng(Number(coord[1]), Number(coord[0]))
        }

        function draw_polygons(coords) {
            var paths = [];
            var polygons = coords.split('|');
            for (var p in polygons) {
                var coords = polygons[p].split(' ');
                var path = [];
                for (var c in coords) {
                    var coord = coords[c].split(',');
                    if (coord.length > 1) {
                        path.push(new google.maps.LatLng(Number(coord[1]), Number(coord[0])));
                    }
                }
                paths.push(path);
            }
            return paths;
        }

        function abrir_dash() {
            dash.aberto = true;
            $(dash).animate({
                right: 0
            }, dur, in_out);
        }

        function fechar_dash(d) {
            dash.aberto = false;
            $(dash).animate({
                right: -400
            }, dur, in_out);
            $(dash_voltar).hide();
            $(dash_topo).css({
                width: ''
            });

            reset_map();
        }

        function reset_map() {
            // bh
            reset_layer(bacia_polygons);
            reset_layer(macro_polygons);
            reset_layer(meso_polygons);
            reset_layer(micro_polygons);

            // OUTROS
            reset_layer(uc_polygons);
            reset_layer(ti_polygons);
            reset_layer(ap_polygons);

            // reset locais
            verifica_locais(false, false);
        }

        dash_topo.onclick = fechar_dash;

        // mobile //

        var mobile;

        var isMobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera: function() {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any: function() {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }
        };

        if (isMobile.any()) {
            mobile = true;
            bt_event = 'touchstart';
        } else {
            mobile = false;
            bt_event = 'click';
        }

        console.log("MOBILE: " + mobile);

        // window funcs

        function map_size() {
            google.maps.event.trigger(map, 'resize');
            map.setZoom(map.getZoom() - 1);
            map.setZoom(map.getZoom() + 1);
        }

        function resize() {
            win_w = $(window).width();
            win_h = $(window).height();
            if (map_ok) map_size();
        }

        resize();
        window.onresize = resize;


        // bts funcs


        function decimal(num, casas, sep) { // sep define o tipo de separação . ou ,
            var nCasas = 1;
            for (var n = 1; n <= casas; n++) {
                nCasas *= 10;
            }
            var valor = Math.round(num * nCasas) / nCasas;
            return decimalSep(valor, sep);
        }

        function decimalSep(num, sep) {
            var numSt = num.toString();
            var indice = numSt.indexOf(".");
            if (indice != -1) {
                var nDecimal = numSt.slice(indice + 1, numSt.length);
                if (nDecimal == 0) {
                    numSt.slice(0, indice);
                } else {
                    return numSt.slice(0, indice) + sep + numSt.slice(indice + 1, numSt.length);
                }
            } else {
                return num;
            }
        }

        function duas_casas(n) {
            if (n < 10) return '0' + n;
            else return n;
        }

        function ordenar(alvo, criterio1, criterio2) {
            alvo.sort(function(a, b) {
                if (a[criterio1] < b[criterio1])
                    return 1;
                if (a[criterio1] > b[criterio1])
                    return -1;
                if (a[criterio1] == b[criterio1]) {
                    if (criterio2 != null) {
                        if (a[criterio2] > b[criterio2])
                            return 1;
                        if (a[criterio2] < b[criterio2])
                            return -1;
                    }
                    return 0;
                }
            });
        }


        ///////////////////////////////////////////////////////////////////////////////////////// LOADMAP

		google.maps.Polygon.prototype.getBounds = function() {
			var bounds = new google.maps.LatLngBounds();
			var paths = this.getPaths();
			var path;
			for (var i = 0; i < paths.getLength(); i++) {
				path = paths.getAt(i);
				for (var ii = 0; ii < path.getLength(); ii++) {
					bounds.extend(path.getAt(ii));
				}
			}
			return bounds;
		}

        function loadMap() {

            centro_ini = new google.maps.LatLng(-15.15, -51.98);
            centro_at = new google.maps.LatLng(-15.15, -51.98);

            var mapOptions = {
                center: centro_at,
                zoom: 4,
                maxZoom: max_zoom,
                minZoom: min_zoom,
                width: '100%',
                height: '100%',
                mapTypeId: google.maps.MapTypeId.SATELLITE,
                panControl: false,
                mapTypeControl: false,
                streetViewControl: false,
                scaleControl: true,
                overviewMapControl: false,
                rotateControl: false,
                zoomControl: false,
                scaleControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_LEFT
                }
            };

            map = new google.maps.Map(mapa, mapOptions);

            google.maps.event.addListener(map, 'dragstart', function() {
                // function onDrag
            });

            google.maps.event.addListener(map, 'dragend', function() {
                centro_at = map.getCenter();
            });

            google.maps.event.addListener(map, 'zoom_changed', function() {
                zoom_at = map.getZoom();
            });

            map_ok = true;

            // BD bacias

            ///////////////// tipo de mapa

            tipos = tipo.getElementsByTagName('li');
            map_types = [
                google.maps.MapTypeId.SATELLITE,
                google.maps.MapTypeId.HYBRID,
                google.maps.MapTypeId.TERRAIN,
                google.maps.MapTypeId.ROADMAP
            ];

            for (i = 0; i < tipos.length; i++) {
                tipos[i].tipo = i;
                tipos[i].onclick = function() {
                    map.setMapTypeId(map_types[this.tipo]);
                    for (i in tipos) {
                        if (tipos[i] == this) {
                            tipos[i].className = 'bt_tipo selected';
                        } else {
                            tipos[i].className = 'bt_tipo ';
                        }
                    }
                }
            }

            ///////////////// zoom

            zoom_at = map.getZoom();

            zoom_in.onclick = function() {
                if (zoom_at < max_zoom) {
                    map.setZoom(zoom_at + 1);
                }
            }

            zoom_out.onclick = function() {
                if (zoom_at > min_zoom) {
                    map.setZoom(zoom_at - 1);
                }
            }

            //////////////////// styles
            //map.setOptions({styles: styles});

            resize();

        } // fim loadMap

        //iniciar

        var menu;

        function listar(cod, lista, layer) {

            $(menu[cod]).each(function(i, d) {

                itm = document.createElement('li');
                itm.ID = i;
                itm.className = 'cont_item';
                itm.innerHTML = d.nome;
                itm.nome = d.nome;
                itm.cod = cod;
                itm.layer = layer;
                itm.id = d.id;

                itm.onclick = function() {
                    if (menu.camadas[this.cod].ativo) {
                        if (this.cod == 'bh') bh_select(this.id, this.layer, true);
                        else bd_select(this.id, this.cod, true, false);
                    }else{
                        alertar("<b>ESTA CAMADA NÃO ESTÁ VISÍVEL!</b> <br>Ative " + menu.camadas[this.cod].label + " no painel de camadas.");
                    }
                }

                lista.appendChild(itm);

            });
        }


        $.post(
                'php_tools/menu.php',
                null,
                function(data) {

                    menu = data;

                    listar('bh', lista_bh, macro_polygons);
                    listar('ap', lista_ap, aps_polygons);
                    listar('uc', lista_uc, ucs_polygons);
                    listar('ti', lista_ti, tis_polygons);

                    // camadas
                    var titulo_extras = false;

                    $(menu.camadas).each(function(i, d) {

                        itm = document.createElement('li');

                        d.itm = itm;
                        itm.d = d;
                        menu.camadas[d.codigo] = d;

                        itm.className = 'cont_item camada';
                        itm.innerHTML = d.label.toUpperCase();

                        console.log('camada extra');
                        console.log(d);

                        if (d.codigo === 'no') { // camada extra

                            if(!titulo_extras){
                                titulo = document.createElement('li');
                                titulo.id = 'camadas_extra';
                                titulo.innerHTML = 'CAMADAS EXTRA';
                                lista_camadas.appendChild(titulo);
                                titulo_extras = true;
                            }

                            d.kmz = new google.maps.KmlLayer({
                                url: 'http://paisagem.wwf.org.br/b2020/camadas/camada'+d.id+'/camada.kmz',
                                preserveViewport: true
                            });

                            google.maps.event.addListener(d.kmz, 'click', function(kmlEvent) {
                                console.log(this);
                            });

                            if (d.ativo) d.kmz.setMap(map);

                            // lista
                            itm2 = document.createElement('li');
                            itm2.ID = i;
                            itm2.className = 'cont_item';
                            itm2.innerHTML = d.label.toUpperCase();
                            itm2.cod = 'no';
                            itm2.layer = d.kmz;
                            itm2.id = d.id;

                            itm2.onclick = function() {
                                if (menu.camadas[this.cod].ativo) {
                                    map.fitBounds(this.layer.getDefaultViewport());
                                }
                            }

                            lista_no.appendChild(itm2);

                        }

                        itm.onclick = function() {
                            if (this.d.ativo) {
                                desativar_camada(this);
                            } else {
                                ativar_camada(this);
                            }
                        }

                        olho = document.createElement('div');
                        olho.className = 'olho';
                        itm.olho = olho;

                        if (d.ativo) {
                            $(olho).css({
                                backgroundColor: d.cor
                            })
                        } else {
                            $(olho).css({
                                backgroundColor: '#e6e6e6'
                            })
                        }

                        itm.appendChild(olho);
                        lista_camadas.appendChild(itm);
                    });

                    // niveis

                    for (i in niveis) {
                        niveis[i].onclick = function() {
                            selecionar_nivel(this.codigo);
                        }
                    }

                    // iniciar

					console.log('iniciar');

                    selecionar_nivel('bh');
                    bh_select(null, principais_polygons, false);

                    //  carregando todos no começo deixa o load inicial muito lento.
                    //  mudei para load por demanda, ao ativar a respectiva camada
                    // bd_select(null, 'uc', false, false);
                    // bd_select(null, 'ti', false, false);
                    // bd_select(null, 'ap', false, false);
                    // bd_select(null, 'pj', false, false);
                    // bd_select(null, 'uh', false, false);

                }, "json")
            .fail(function(xhr, textStatus, errorThrown) {
                console.log("error " + textStatus + " : " + errorThrown);
            });


        loadMap();

    } // fim window.onload
