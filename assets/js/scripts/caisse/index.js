var SCANNER = false ;

function strstr(haystack, needle, bool) {
    var pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle); if (pos == -1) {
        return false;
    } else {
        if (bool) {
            return haystack.substr(0, pos);
        } else {
            return haystack.slice(pos);
        }
    }
}

function showModalAppelPrix()
{
	var text_caisse = $('#text_caisse').val() ,
	test = strstr(text_caisse,"X") ;

	if ( text_caisse !== '' && test) {
		$('#modalAppelPrix').modal('show') ;
	}
	else{
		$.growl.error({ title:"", message: "Veuillez entrer la quantité"});
	}
}

function CBFormAppelPrix(item){
	var codeb = $(item).data('code_barre') ;
	$('input#text_caisse').val(function(){
		return this.value + codeb ;
	}) ;
	caisse_OK() ;
	$('#modalAppelPrix').modal('hide') ;
}

function animateButton(v) {
	var button = $('.btn_'+v).addClass('selected') ;
	setTimeout(function() {
	button.removeClass('selected');
	}, 100);
}

function clearDiv(id){
	$('#'+id).val('');
}

function retour_caisse(){
	var text = $('input[type=text]#text_caisse').val();
	var longueur = text.length;
	text = text.substring(0, longueur-1);
	$('input[type=text]#text_caisse').val(text);
}

function reload_caisse(){
	clearDiv('text_caisse') ;
}

var incr = 1 ;
function caisse_OK(){			
	if ($('#text_caisse').val()!=''){
		var text = $('#text_caisse').val();
		text = text.split('X');

		var tabArticle = [];

		$("#content_table_caisse tr").each(function() {
		    var arrayOfThisRow = [];
		    var tableData = $(this).find('td');
		    if (tableData.length > 0) {
		        tableData.each(function() { arrayOfThisRow.push($(this).text()); });
		        tabArticle.push(arrayOfThisRow);
		    }
		});

		$.post(root+'caisse/Getcontentproduct', 
	    {
	        "quantite":text[0]
	        ,"CDB":text[1]
	        ,"incr" : incr 
	        ,"scanner" : false 
	        ,"tabArticle" : tabArticle 
	    },
	    function(d){
	    	if (d.state == 'success') {
	    		$('#content_table_caisse').append(d.table_content) ;
	    		clearDiv('text_caisse') ;

				if ($('#total_caisse').text()!=''){
					var total = Number($('#total_caisse').text()) + d.sous_total_article;
					$('#total_caisse').text(total);
				}
				else
				{
					$('#total_caisse').text(d.sous_total_article);
				}
	    	}
	    	else{
    			$.growl.error({ title:"", message: d.msg });
    			clearDiv('text_caisse') ;
	    	}
	    }, 'json');
	}
	else
	{
		$.growl.warning({ title:"", message: "Champ obligatoire" });
	}

	incr++ ;
}

function print_caisse() {
	$('input[type=hidden]#modePaiement').val('1') ;
	$('#Content_RenduMP').removeClass('hide');
	$('#Content_ReferenceMP').addClass('hide');
	$('button.modePaiement').removeClass('selectedModePaiement') ;
	$('button.mp_1').addClass('selectedModePaiement') ;

	if ( $("#content_table_caisse tr").find('td').length === 0) {
		$.growl.warning({ title:"", message: "Votre panier est encore vide"});
	}
	else{
		var a = $('#total_caisse').text();

		maskInput('RecuMP') ;
		maskInput('ReferenceMP') ;
		
		$('#TotalMP').val(a);
		$('#ResteMP').val(a);
		$('#RenduMP').val('');
		$('#RecuMP').val('');
		$('#modalModePaiement').modal();		
	}
}

function maskInput(id){
    $('#'+id).mask('###', {reverse: true});
}

function MP_OK() {
	function imprimer()
	{
		window.print();
	}

	var tabArticle = [];

	$("#content_table_caisse tr").each(function() {
	    var arrayOfThisRow = [];
	    var tableData = $(this).find('td');
	    if (tableData.length > 0) {
	        tableData.each(function() { arrayOfThisRow.push($(this).text()); });
	        tabArticle.push(arrayOfThisRow);
	    }
	});

	var idModePaiement = $('input[type=hidden]#modePaiement').val() ,
	montant = $('#TotalMP').val() ,
	montant_recu ;
	
	if($('#Content_RenduMP').is(':visible')){
		var RR = $('#RenduMP').val() ,
		montant_recu = $('input#RecuMP').val() ;
	}

	if($('#Content_ReferenceMP').is(':visible')){
		var RR = $('#ReferenceMP').val();
	}

	$.ajax({
		url: root+'caisse/Add',
		type: 'POST',					
		data: {
			"TABARTICLE": tabArticle
			,"MODEPAIEMENT":idModePaiement
			,"RR":RR
			,"MONTANT":montant
			,"MONTANT_RECU":montant_recu
		},
		dataType:"json" ,
		beforeSend: function (){
			$('div.modal-body').block({ 
				message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
				overlayCSS: {
					backgroundColor: '#fff',
					opacity: 0.8,
					cursor: 'wait'
				},
				css: {
					border: 0,
					padding: 0,
					backgroundColor: 'transparent'
				}
			});
			},
		success : function(d){
			$('div.modal-body').unblock() ;

			if (d.state === 'error' || d.state === 'paiement_not_enough' || d.state === 'no_phone_number' || d.state === 'cheque_invalide') {
				$.growl.warning({ title:"", message: d.msg });
			}
			else{
				$('#content_table_caisse').empty();
				$('span#total_caisse').text('') ;
				clearDiv('text_caisse') ;
				$('#modalModePaiement').modal('hide');
				window.open(root+'/uploads/Ticket/Ticket-'+d.fact+'.pdf','_blank');
				// window.setTimeout(imprimer,1000);
			}
		}			
	}); 
}

function deleteLigne(item){
	var ligne = $(item).data('ligne') ,
	article_id = $('tr#ligne_'+ligne).data('article_id') ,
	quantite = $('tr#ligne_'+ligne).data('quantite') ;

	$.post(root+'caisse/deleteLigne', 
    {
        "article_id":article_id
        ,"quantite":quantite
    },
    function(d){
    	$('tr#ligne_'+ligne).empty() ;

		var total_c = $('#total_caisse').text();
		var total_f = total_c - d.total ;
		$('#total_caisse').text(total_f);
    }, 'json');
}

function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    $('#heure_caisse').text(h + ":" + m + ":" + s) ;
    var t = setTimeout(startTime, 500);
}

function checkTime(i) 
{
    if (i < 10) {i = "0" + i}; 
    return i;
}

function Afficher_RR(item) 
{	
	$('button.modePaiement').removeClass('selectedModePaiement') ;
	$(item).addClass('selectedModePaiement') ;

	var rr = $(item).data('rr') ,
	prefixe = $(item).data('prefixe') ,
	id_mp = $(item).data('id_mp') ;

	$('input[type=hidden]#modePaiement').val(id_mp) ;

	if (rr==0){				
		$('#ReferenceMP').val(prefixe);
		$('#ResteMP').val($('#TotalMP').val());
		$('#Content_ReferenceMP').removeClass('hide');
		$('#Content_RenduMP').addClass('hide');
	}
	if (rr==1){
		$('#RecuMP').val('');
		$('#RenduMP').val('');
		$('#ResteMP').val($('#TotalMP').val());
		$('#Content_RenduMP').removeClass('hide');
		$('#Content_ReferenceMP').addClass('hide');
	}
}

function updateToTalRecu(){
	var a = Number($('#RecuMP').val());
	var b = Number($('#TotalMP').val());
	var s = a - b;
	if (s>0){
		$('#RenduMP').val(s);
	}	
	else 
	{
		$('#RenduMP').val('');
	}	

	if(s>=0){				
		$('#ResteMP').val('0');
	}	
	else
	{
		s = s * -1;
		$('#ResteMP').val(s);
	}
}

function retour_MP(){
	if($('#Content_RenduMP').is(':visible')){
		var text = $('#RecuMP').val();
		var longueur = text.length;
		text = text.substring(0, longueur-1);
		$('#RecuMP').val(text);

		/*UPDATE RECU AND TOTAL*/
		updateToTalRecu() ;
	}	

	if($('#Content_ReferenceMP').is(':visible')){
		var text = $('#ReferenceMP').val();
		var longueur = text.length;
		text = text.substring(0, longueur-1);
		$('#ReferenceMP').val(text);
	}		
}

function reload_MP(){
	if($('#Content_RenduMP').is(':visible')){
		clearDiv('RecuMP') ;
	}

	if($('#Content_ReferenceMP').is(':visible')){
		clearDiv('ReferenceMP') ;
	}
}

function activeKeyboard()
{
	$(document).keypress(function (e) {
		var charCode = e.which;
		var key = String.fromCharCode(charCode);

		// alert(charCode) ;

		if ( (charCode >= 48 && charCode <= 57) || charCode === 105 || charCode === 114 || charCode === 42 || charCode === 120) {
			if ($('div#modalModePaiement').is(':visible')) {
				var mp = $('input[type=hidden]#modePaiement').val() ,
				inp ;

				inp = (mp == 1) ? 'RecuMP' : 'ReferenceMP' ;

				if (charCode !== 114 && charCode !== 105 && charCode !== 120 && charCode !== 42) {
				// if (!$.inArray(charCode,['114','105','120','42'])) {
					$('input[type=text]#'+inp).val(function(){
						return this.value + key ;
					}) ;
				}

				if(charCode === 114 ){
					reload_MP() ;
				}

				/*update reste a payer*/
				if($('#Content_RenduMP').is(':visible')){
					updateToTalRecu() ;
				}
			}
			else{
				if(charCode === 105 || charCode === 114){
					if(charCode === 105){
						print_caisse();
					}

					if (charCode === 114) {
						if ($('div#modalModePaiement').is(':visible')) {
							reload_MP() ;
						}
						else{
							clearDiv('text_caisse') ;
						}
					}
				}
				else{
					if(charCode === 42 || charCode === 120){
						key = 'X' ;
					}

					$('input#text_caisse').val(function(){
						return this.value + key ;
					}) ;
				}
			}

			animateButton(charCode);
		}
	});

	// keydown for backspace and enter
	$(document).keydown(function (e) {
		var charCode = e.which;

		// BACKSPACE
		if ( charCode === 8 ) {
			if ($('div#modalModePaiement').is(':visible')) {
				retour_MP() ;
			}	
			else{
				retour_caisse() ;
			}
			animateButton(8);
			return false;
		}

		// ENTRER
		if ( charCode === 13 ) {
			if ($('div#modalModePaiement').is(':visible')) {
				MP_OK() ;
			}
			else{
				caisse_OK() ;
			}
			animateButton(13);
			return false;
		}
	});
}

$(document).ready(function(){
	// $('input.use_CB').change(function(){
	//     if(!$(this).is(':checked')){
	//     	activeKeyboard(true) ;
	//     }
	//     else{
	//     	activeKeyboard(false) ;
	//     }
	    
	// });

	activeKeyboard() ;

	$('#text_caisse').hover(function() {
		$('#text_caisse').attr('disabled','true');
	}, function() {
		$('#text_caisse').removeAttr('disabled');
	});

	$('.btn').click(function() {
		if($('#text_caisse').val()!=''){
			var a = $('#text_caisse').val();
			$('#text_caisse').val(a+$(this).val());					
		}
		else
		{
			$('#text_caisse').val($(this).val());
		}				
	});

	$('.B').click(function() {
		if($('#Content_RenduMP').is(':visible')){
			if($('#RecuMP').val()!=''){
				var a = $('#RecuMP').val();
				$('#RecuMP').val(a+$(this).val());
				$('#text_caisse').val('');
			}
			else
			{
				$('#RecuMP').val($(this).val());
				$('#text_caisse').val('');
			}
			var a = Number($('#RecuMP').val());
			var b = Number($('#TotalMP').val());
			var s = a - b;
			if (s>0){
				$('#RenduMP').val(s);
			}	
			else 
			{
				$('#RenduMP').val('');
			}	

			if(s>=0){				
				$('#ResteMP').val('0');
			}	
			else
			{
				s = s * -1;
				$('#ResteMP').val(s);
			}
		}

		if($('#Content_ReferenceMP').is(':visible')){
			if($('#ReferenceMP').val()!=''){
				var a = $('#ReferenceMP').val();
				$('#ReferenceMP').val(a+$(this).val());
				$('#text_caisse').val('');
			}
			else
			{
				$('#ReferenceMP').val($(this).val());
				$('#text_caisse').val('');
			}
		}
	});
});	

var incr = 1 ;
$(document).scannerDetection({
	timeBeforeScanTest: 200, 
	avgTimeByChar: 100,
	onComplete: function(barcode){
		SCANNER = true;
		var tCaisse = $('#text_caisse').val() ,
		qte ;

		qte = (tCaisse == '') ? 1 : tCaisse ;

		var tabArticle = [];

		$("#content_table_caisse tr").each(function() {
		    var arrayOfThisRow = [];
		    var tableData = $(this).find('td');
		    if (tableData.length > 0) {
		        tableData.each(function() { arrayOfThisRow.push($(this).text()); });
		        tabArticle.push(arrayOfThisRow);
		    }
		});

	    $.ajax({
	    	url: root+'caisse/Getcontentproduct',
	    	type: 'POST',					
	    	data: {
	    		"quantite":qte
	    		,"CDB":barcode
	    		,"incr" : incr 
	    		,"scanner" : true 
	    		,"tabArticle" : tabArticle 
	    	},
	    	dataType:"json" ,
	    	success : function(d){
		    	if (d.state == 'success') {
		    		$('#content_table_caisse').append(d.table_content) ;
		    		clearDiv('text_caisse') ;

					if ($('#total_caisse').text()!=''){
						var total = Number($('#total_caisse').text()) + d.sous_total_article;
						$('#total_caisse').text(total);
					}
					else
					{
						$('#total_caisse').text(d.sous_total_article);
					}
		    	}
		    	else{
	    			$.growl.error({ title:"", message: d.msg });
	    			clearDiv('text_caisse') ;
		    	}
	    	}			
	    }); 

	   	incr++ ;
    }
    // ,onError: function () {
    // 	console.log("Veuillez réessayer ou activer votre MAJ");
    // }
});	