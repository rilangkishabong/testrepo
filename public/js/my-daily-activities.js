$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    })
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#act_date').attr('min', today);
    $("#addRow").click(function() {
        var html = '';
        html += '<div id="inputFormRow" class="row">';
        html += '<div class="col-sm-4"';
        html += '<label for="">Activity/Task Name</label>';
        html += '<input type="text" class="form-control" id="act_name[]" name="act_name[]"' +
            'placeholder="Activity Name" required>';
        html += '</div>';
        html += '<div class="col-sm-4">';
        html += '<label for="">Activity Status</label>';
        html += '<select class="form-control" name="act_stat[]" id="act_stat[]" required>';
        html += '<option value="">Select Status</option>';
        html += '<option value="Completed">Completed</option>';
        html += '<option value="Pending">Pending</option>';
        html += '<option value="To Be Continued">To Be Continued</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="col-sm-4">';
        html += '<label for="">Time Taken(in hrs)</label>';
        html += '<input type="number" class="form-control" id="act_time[]" name="act_time[]"' +
            'placeholder="" required>';
        html += '</div>';
        html += '<button type="button" id="removeRow" class="btn btn-primary">Remove Activity</button>';
        html += '</div>';
        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function() {
        $(this).closest('#inputFormRow').remove();
    });
});
