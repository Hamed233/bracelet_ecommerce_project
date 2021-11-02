/* For Edit image */
$(document).ready(function() {
    fetch_data();

    function fetch_data() {
        var action = "fetch";
        $.ajax({
            url: "includes/actions/action.php",
            method: "POST",
            data: {
                action: action
            },
            success: function(data) {
                $('#image_data').html(data);
            }
        });
    }

    $('#image_form').submit(function(event) {
        event.preventDefault();
        var image_name = $('#image').val();
        if (image_name == '') {
            alert("Please Select Image");
            return false;
        } else {
            var extension = $('#image').val().split('.').pop().toLowerCase();
            if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                alert("Invalid Image File");
                $('#image').val('');
                return false;
            } else {
                $.ajax({
                    url: "includes/actions/action.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        fetch_data();
                        $('#image_form')[0].reset();
                        $('#imageModal').modal('hide');
                    }
                });
            }
        }
    });

    $(document).on('click', '.update', function() { // update categories_img
        $('#image_id').val($(this).attr("id"));
        $('#action').val("update");
        $('.modal-title').text("Update Image");
        $('#insert').val("Update");
        $('#imageModal').modal("show");
    });

    $(document).on('click', '.update_product_img', function() { // update_product_img
        $('#image_id').val($(this).attr("id"));
        $('#action_pro').val("update_product_img");
        $('.modal-title').text("Update Image");
        $('#insert_pro').val("Update");
        $('#imageModal').modal("show");
    });

    $(document).on('click', '.update_adm_img', function() { // update_adm_img
        $('#image_id').val($(this).attr("id"));
        $('#action_adm').val("update_adm_img");
        $('.modal-title').text("Update Image");
        $('#insert_adm').val("Update");
        $('#imageModal').modal("show");
    });
});