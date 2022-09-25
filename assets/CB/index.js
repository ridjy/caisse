$(document).ready(function(){
	maskInput('code_barre',true) ;
	onKeyUpCodeBarre() ;


	var bool ;
	$('#Generer_CB').click(function() {
		$('div#resultCB').addClass('hide') ;
	    var code = $('#code_barre').val();

	    if(!code.length){
	    	$.growl.error({ title:"", message: "Veuillez entre le code barre à génerer" });
	    }
	    else{
	    	generateCodeBarreGetArticle(code) ;
	    }
	});

	$('#Annuler_CB').click(function(event) {
	    $('div#Logo_CB').removeClass('hide') ;
	    $('div#resultCB').addClass('hide') ;
	    $('#code_barre').val('');
	    $('div#html_append').empty() ;
	});
});

$(document).scannerDetection({
	timeBeforeScanTest: 200, 
	avgTimeByChar: 100,
	onComplete: function(barcode){
		generateCodeBarreGetArticle(barcode) ;
    },
    onError: function () {
    	console.log("Veuillez réessayer ou activer votre MAJ");
    }
});	

/*CODE BARRE*/
function onKeyUpCodeBarre()
{
    $("input#code_barre").keyup(function(event) {
        var value = $('input#code_barre').val() ;

        if (value.length > 13) {
            $.growl.error({ title:"", message: "07 chiffres maximum" });
            $("input#code_barre").val("") ;
        }
        
    });
}

function generateCodeBarreGetArticle(code)
{
	blockDiv() ;
	
    JsBarcode("#Image_CB")
   .options({
        font: "OCR-B"
        ,valid:function(res){
            bool = res ;
        }
    }) 
	.EAN13(code, {fontSize: 20, textMargin: 1, height:75,  fontOptions: "bold"})    
	.render();

	if (bool) {
		setTimeout(unblockDiv,1000);

		$.post(root+'/ajax/getarticle', 
		{
			"codebarre_article":code   
		},
		function(d){
			function hidden(d){
				$('div#Logo_CB').addClass('hide	') ;
				$('div#resultCB').removeClass('hide') ;

				// if (d.state === 'success') {
				// 	$('button#Imprimer_CB').data('code_barre',code) ;
				// 	$('button#Imprimer_CB').data('nom_article',d.nom_article) ;
				// 	$('button#Imprimer_CB').data('uniqid',d.uniqid) ;
				// 	$('button#Imprimer_CB').removeClass('hide') ;
				// }
				// else{
				// 	$('button#Imprimer_CB').data('code_barre','') ;
				// 	$('button#Imprimer_CB').addClass('hide') ;
				// }

				$('button#Imprimer_CB').addClass('hide') ;

				$('div#html_append').html(d.content) ;

			}

			setTimeout(hidden,1000,d) ;
		}, 'json');
	}
	else{
		unblockDiv() ;
		$.growl.error({ title:"", message: "Code barre erronné" });
	}
}

function blockDiv(){
	$('div.panel-body').block({ 
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
}

function unblockDiv(){
	$('div.panel-body').unblock() ;
}

function Imprimer_CB(item){
 //    var imgData = $('#Image_CB').attr('src');
 //    var a = $('#code_barre').val();			
	// var doc = new jsPDF("l","mm",[50,20]);	
	// doc.addImage(imgData, 'PNG', 7, 3, 40, 15);	
	// doc.setFontType("bold");
	// doc.setFontSize(8);					
 //    doc.output('dataurlnewwindow');

 	var code_barre = $(item).data('code_barre') ,
 	nom_article = $(item).data('nom_article') ,
 	uniqid = $(item).data('uniqid') ,
    imgData;

 	// console.log("CB : "+code_barre) ;
 	// console.log("Nom : "+nom_article) ;
 	// console.log("REF : "+uniqid) ;

    html2canvas($("#img_result"), {
    	useCORS: true,
    	onrendered: function (canvas) {
    		imgData = canvas.toDataURL(
    		'image/png');
    		var doc = new jsPDF("l","mm",[30,40]);

    		/*back 300318*/
    		// doc.addImage(imgData, 'PNG', 0, 3, 55, 15);	
			// doc.setFontType("bold");
			// doc.setFontSize(8);	
    		// doc.save(code_barre+'.pdf');

    		doc.setFontType("bold");
            doc.setFontSize(5);  
            doc.text(5, 3,'Nom : '+nom_article);
            doc.text(5, 6, 'Ref : '+uniqid);
            // X Y
            doc.addImage(imgData, 'PNG', 0, 3, 55, 15);	
            // X Y largeur hauteur
            doc.save(code_barre+'.pdf');
            //doc.print(code_barre+'.pdf');
            //window.print(doc);

    	}
    });
}