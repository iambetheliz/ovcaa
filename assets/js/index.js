
    $(window).load(function(){
                $('#onload').modal('show');
            });

    $(document).ready(function(){
$("#table-id #checkall").click(function () {
        if ($("#table-id #checkall").is(':checked')) {
            $("#table-id input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#table-id input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    
    $("[data-toggle=tooltip]").tooltip();
});