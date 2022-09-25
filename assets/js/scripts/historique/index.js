$(document).ready(function(){
    $(function(){ 
        $('#dataTable').dataTable({
            "bJQueryUI"  : true,
            "bAutoWidth" : false,
            "bProcessing": false,
            "bServerSide": true,
            "sAjaxSource": root+"/historique/getHistorique/format/html",
            "sPaginationType": "full_numbers",
            // "sDom": '<"datatable-header"fril>t<"datatable-footer"p>',
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength" : 100,
            "oLanguage": {
             "sSearch": "_INPUT_",
             "sLengthMenu": "<span>Entrées : </span> _MENU_",
             "oPaginate": { "sFirst": "Première page", "sLast": "Dernière page", "sNext": ">", "sPrevious": "<" }
            },
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false }
            ],
            "fnDrawCallback": function (oSettings) {
                $('.dataTables_filter input').attr("placeholder", "Votre recherche ici ...");
            }
        });          
    });
})

function showModal(item){
    var resource_id = $(item).attr('data-resource_id') ,
    resource_type = $(item).attr('data-resource_type') ;
    
    $.post(root+'/historique/showmodal', 
    {
        "resource_id":resource_id   
        ,"resource_type":resource_type
    },
    function(d){
        if (resource_type == 'showFacture') {
            $("#modalContent").removeClass('modal-md').addClass('modal-sm') ;
            $("div#showModal input[type='submit']").addClass('hide') ;
        }

        $('#showModal h4.modal_title').html(d.modal_title);
        $('#showModal .htmlWrapper').html(d.htmlWrapper);
        $('#showModal').modal('show');
    }, 'json');
}

function deleteFacture(item)
{
    var resource_id = $(item).attr('data-resource_id') ;

    swal({
        title: "Supprimer cette Facture ?" ,
        showCancelButton: true,
        confirmButtonColor: "#EF5350",
        confirmButtonText: "Oui",
        cancelButtonText: "Non",
        closeOnConfirm: false,
    },
    function(isConfirm){
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url:root+"/historique/delete/format/html",
                data: {"resource_id":resource_id},
                dataType: "json",
                success: function (data) {
                    swal({
                        title: data.msg,
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    });
                    $('#dataTable').dataTable().fnDraw();
                }
            });
        }
    });
}