function updateInfos(){
    var data = $('form.updateInfos').serialize() ;

    $.ajax({
        type: "POST",
        url:root+"/infos/update/format/html" ,
        data: data ,
        dataType:"json" ,
        beforeSend: function (){
          $('form.updateInfos').block({ 
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
    	 	$('form.updateInfos').unblock() ;

        	if (d.state == 'empty_field' || d.state == 'empty_pseudo' || d.state == 'empty_password' || d.state == 'user_not_found') {
        		$.growl.warning({ title:"", message: d.msg });
        	}
        	else if(d.state == 'success') {
        		$.growl.notice({ title:"", message: d.msg });
                // function redirection(){
                //     window.location.href='/';
                // }
                // setTimeout(redirection,2000);
        	}
        }
    });
}