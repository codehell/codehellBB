
$(document).ready(function () {

    $( "#predelete" ).click(function() {

        $( "#delete_form" ).removeClass('hidden');

    });

    $( "#pre_delete_post" ).click(function() {

        $( "#pre_delete_post_div" ).addClass('hidden');
        $( "#delete_post_div" ).removeClass('hidden');

    });

    $( "#cancel_delete_post" ).click(function() {

        $( "#delete_post_div" ).addClass('hidden');
        $( "#pre_delete_post_div" ).removeClass('hidden');

    });

    $('#myModal').on('show.bs.modal', function (event) {
        $('#add_comment').removeAttr('disabled','disabled');
        var button = $(event.relatedTarget); // Button that triggered the modal
        var form = $('#form-store');
        var url = form.data('store_action');
        var url_update = form.data('update_action');
        var url_destroy = form.data('destroy_action');
        var comment_id = button.data('comment');
        var method = $("#method");
        var add_comment = $("#add_comment");
        var destroy_comment = $("#destroy_comment");
        var comment = $('#comment');
        var text = '';
        add_comment.one();
        add_comment.removeClass('hidden');
        destroy_comment.addClass('hidden');
        comment.val('');
        if (button.data('reply') == 'reply-comment') {

            form.attr('action', url + "/" + comment_id);

        }else if (button.data('reply') == 'reply-post') {

            form.attr('action', url);

        }else if (button.data('reply') == 'edit-comment') {

            text = $('#comment_' + comment_id).text();
            form.attr('action', url_update + "/" + comment_id);
            method.attr('value', 'PATCH');
            comment.val(text);

        }else if (button.data('reply') == 'destroy-comment') {

            text = $('#comment_' + comment_id).text();
            form.attr('action', url_destroy + "/" + comment_id);
            method.attr('value', 'DELETE');
            comment.val(text);
            add_comment.addClass('hidden');
            destroy_comment.removeClass('hidden');
        }
    });

    $('#form-store').one('submit', function() {
        $(this).find('button[type="submit"]').attr('disabled','disabled');
    });

    $('#comment').parsley().on('field:success', function() {
        $('#add_comment').removeAttr('disabled','disabled');
    });
});