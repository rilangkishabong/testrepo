$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    $(".btndeputaccept").click(function(e) {
        e.preventDefault();
        var myid = $(this).data("id");
        $.ajax({
            type: "post",
            url: "UpdateDeputeStatus",
            data: { myid: myid },
            success: function(response) {

                alert("Status Updated Successfully");
                location.reload();
            },
            error: function(response) {
                alert("Error");
            }
        });
    });
});
