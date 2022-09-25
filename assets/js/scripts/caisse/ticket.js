$(document).ready(function(){
    $('form#caisse_ticket').submit(function(e){
        e.preventDefault();

        var data = $('form#caisse_ticket').serialize() ;

        $.ajax({
            type: "POST",
            url:root+"/caisse/updateTicket/format/html" ,
            data: data ,
            dataType:"json" ,
            beforeSend: function (){
              $('form#caisse_ticket').block({ 
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
            success: function (d) {
                $('form#caisse_ticket').unblock() ;

                if (d.state == 'success') {
                    $.growl.notice({ title:"", message: d.msg });
                }
                else{
                    $.growl.warning({ title:"", message: d.msg });
                }
            }
        });
    });

	onKeyUpCodeBarre() ;
});

function onKeyUpCodeBarre()
{
    maskInput('codebarre',true) ;
    $("input#codebarre").keyup(function(event) {
        var value = $('input#codebarre').val() ;

        if (value.length > 7) {
            $.growl.error({ title:"", message: "07 chiffres maximum" });
            $("input#codebarre").val("") ;
        }
        
    });
}