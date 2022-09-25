$(document).ready(function(){
    $('form#siteConfiguration').submit(function(e){
        e.preventDefault();

        var data = $('form#siteConfiguration').serialize() ;

        $.ajax({
            type: "POST",
            url:root+"/options/update/format/html" ,
            data: data ,
            dataType:"json" ,
            beforeSend: function (){
              $('form#siteConfiguration').block({ 
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
                $('form#siteConfiguration').unblock() ;

                if (d.state == 'success') {
                    $.growl.notice({ title:"", message: d.msg });
                }
            }
        });
    });
})