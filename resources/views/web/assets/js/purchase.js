$(function () {
    var formUserPurchase = $('#formUserPurchase');
    var user = formUserPurchase.find('input');
    var alert = formUserPurchase.find('.text-danger');

    formUserPurchase.submit(function (e) {
        e.preventDefault();

        alert.addClass('d-none');
        user.attr('style', '');

        if (user.val().trim() == '') {
            user.css({"border": "1px solid #f00", "color": "#f00"}).select();
            alert.removeClass('d-none');
        } else {
            $('#passo01').modal('hide');
            $('.userInstagram').html('Usuário: ' + user.val());
            $('input[name="profile"]').val(user.val());
            $('#passo02').modal('show');
        }
    });

    $('#passo01').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var quantity = button.data('quantity') // Extract info from data-* attributes
        var price = button.data('price')
        var action = button.data('action')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);

        $('#quantityInstagram').html('Quantidade: ' + quantity)
        $('#totalInstagram').html('Total: R$' + price * quantity)
        $('#formPurchase').attr('action', action)
        $('input[name="quantity"]').val(quantity);
    })

})
