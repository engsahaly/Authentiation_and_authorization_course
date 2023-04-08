<script src="{{ asset('assets-back') }}/jquery-3.6.0.min.js"></script>
<script>
    $("document").ready(function() {
        //============================================= LOADER
        var $loading = $('#loading').hide();
        $(document)
            .ajaxStart(function() {
                $loading.show();
            })
            .ajaxStop(function() {
                $loading.hide();
            });

        //============================================= AJAX REQUEST FOR SHOWING ADD NEW RECORD MODAL
        $(document).on('click', "#add_btn", function(e) {
            e.preventDefault();
            let url = $(this).attr("href");
            let title = $(this).attr("data-title");
            $("#modal-title").html(title);
            $.ajax({
                url: url,
                method: "get",
                success: function(data) {
                    $("#modal-body").html(data);
                },
                error: function() {
                    alert("Please try again ... ");
                }
            });
        });

        //============================================= AJAX REQUEST FOR ADDING RECORD
        $(document).on('click', "#submit_add_form", function() {
            let theForm = $("#add_form");
            let formAction = theForm[0].action;
            let formMethod = theForm[0].method;
            let formData = new FormData($('#add_form')[0]);

            $.ajax({
                url: formAction,
                method: formMethod,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    if (data['failed']) {
                        $("#add_form_messages").empty().removeClass()
                            .addClass('alert alert-danger').append(data['failed'])
                            .get(0).scrollIntoView({
                                behavior: 'instant',
                                block: 'center'
                            });
                    } else {
                        $('#add_form').find('small').remove();
                        $("#add_form_messages").empty().removeClass()
                            .addClass('alert alert-success').append(data['success'])
                            .get(0).scrollIntoView({
                                behavior: 'instant',
                                block: 'center'
                            });

                        setTimeout(function() {
                            $(':input', '#add_form')
                                .not(':button, :submit, :reset, :hidden')
                                .val('')
                                .prop('checked', false)
                                .prop('selected', false);
                            $("#add_form_messages").empty().removeClass();
                            $("#mainModal").modal('hide');
                            $("#mainCont").load(" #mainCont > *");
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    $('#add_form').find('small').remove();
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        let el = $(document).find('[name="' + key + '"]').first();
                        el.after($('<small class="text-danger">' + value[0] +
                            '</small>'));
                    });
                },
            });
        });

        //============================================= AJAX REQUEST FOR SHOWING DELETE MODAL
        $(document).on('click', ".deleteClass", function(e) {
            let url = $(this).attr("href");
            let title = $(this).attr("data-title");
            $("#delete-modal-title").html(title);
            $("#submit_delete").attr("href", url);
        });

        //============================================= AJAX REQUEST FOR DELETING RECORD
        $(document).on('click', "#submit_delete", function(e) {
            e.preventDefault();
            let url = $(this).attr("href");
            $.ajax({
                url: url,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    $("#delete_alert_div").removeClass().addClass('alert alert-success')
                        .append(data['success']);

                    setTimeout(function() {
                        $("#mainCont").load(" #mainCont > *");
                        $("#deleteModal").load(" #deleteModal > *");
                        $('#deleteModal').modal('toggle');
                    }, 1000);
                },
                error: function() {
                    alert("Please try again ...");
                }
            });
        });

        //============================================= SCRIPT FOR SHOWING EDITING MODAL
        $(document).on('click', ".editClass", function(e) {
            e.preventDefault();
            let url = $(this).attr("href");
            let title = $(this).attr("data-title");
            $("#modal-title").html(title);
            $.ajax({
                url: url,
                method: "get",
                success: function(data) {
                    $("#modal-body").html(data);
                },
                error: function() {
                    alert("Please try again ... ");
                }
            });
        });

        //============================================= AJAX REQUEST FOR UPDATING
        $(document).on('click', "#submit_edit_form", function() {
            let theForm = $("#edit_form");
            let formAction = theForm[0].action;
            let formMethod = theForm[0].method;
            let formData = new FormData($('#edit_form')[0]);

            $.ajax({
                url: formAction,
                method: formMethod,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    if (data['failed']) {
                        $("#edit_form_messages").empty().removeClass()
                            .addClass('alert alert-danger').append(data['failed'])
                            .get(0).scrollIntoView({
                                behavior: 'instant',
                                block: 'center'
                            });
                    } else {
                        $('#edit_form').find('small').remove();
                        $("#edit_form_messages").empty().removeClass()
                            .addClass('alert alert-success').append(data['success'])
                            .get(0).scrollIntoView({
                                behavior: 'instant',
                                block: 'center'
                            });

                        setTimeout(function() {
                            $("#mainCont").load(" #mainCont > *");
                            $("#edit_form_messages").empty().removeClass();
                            $("#mainModal").modal('hide');
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    $('#edit_form').find('small').remove();
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        let el = $(document).find('[name="' + key + '"]').first();
                        el.after($('<small class="text-danger">' + value[0] +
                            '</small>'));
                    });
                }
            });

        });

        //============================================= SCRIPT FOR DISPLAYING RECORD DETAILS ON MODAL
        $(document).on('click', ".displayClass", function(e) {
            e.preventDefault();
            let formAction = $(this).attr("href");
            let title = $(this).attr("data-title");
            $("#modal-title").html(title);
            $.ajax({
                url: formAction,
                method: "get",
                success: function(data) {
                    $("#modal-body").html(data);
                },
                error: function() {
                    alert("failed .. Please try again !");
                }
            });
        });

        //============================================= SCRIPT FOR DISPLAYING RECORD DETAILS ON MODAL
        $(document).on('click', "#selectAll", function() {
            $('input[name^=permissionArray]:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>
