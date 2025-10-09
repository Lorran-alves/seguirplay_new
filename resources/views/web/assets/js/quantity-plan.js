var quantityChange = 0;
var id;

$('.plan-quantity-max').click(function () {
    var quantity = $(this).data('quantity')
    var price = $(this).data('price')

    if (id != $(this).data('id')) {
        quantityChange = 0;
    }

    quantityChange++;
    id = $(this).data('id')

    var total = (quantity + quantityChange) * price;
    var totalConvert = total.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

    $(this).parent().prev().find('h3').html(quantity + quantityChange)
    $(this).parent().parent().parent().find('h4').html(totalConvert)
})

$('.plan-quantity-less').click(function () {
    var quantity = $(this).data('quantity')
    var price = $(this).data('price')

    if (id != $(this).data('id')) {
        quantityChange = 0;
    }

    if (quantityChange > 0) {
        quantityChange--;
    }

    id = $(this).data('id')

    var total = (quantity + quantityChange) * price;
    var totalConvert = total.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});

    $(this).parent().next().find('h3').html(quantity + quantityChange)
    $(this).parent().parent().parent().find('h4').html(totalConvert)
})
