$(document).ready(function () {

    // add product btn

    $('.add-product-btn').on('click', function (e) {

        e.preventDefault();
        var name    = $(this).data('name');
        var id      = $(this).data('id');
        var price   = accounting.format($(this).data('price'), 2);
        var unitPriceWithoutFormat  = $(this).data('price'); 

        $(this).removeClass('btn-success').addClass('btn-default disabled');

        var html = 
                `<tr>
                    <td>${name}</td>
                    <input type="hidden" name="product_ids[]" value="${id}">
                    <td><input type="number" name="quanities[]" data-price="${unitPriceWithoutFormat}" class="form-control input-sm product-quantity" min="1" value="1"></td>
                    <td class="product-price">${price}</td>
                    <td><button class="btn btn-danger btn-sm remove-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>`;
        


        // append order

        $('.order-list').append(html);

        // total price

        calculateTotal();

    });

    // prevent-default disabled btns
    $('body').on('click', '.disabled',function(e){
        e.preventDefault();
    });

    //remove btn
    $('body').on('click', '.remove-btn',function(e){

        e.preventDefault();

        var id = $(this).data('id');

        //remove order

        $(this).closest('tr').remove();

        // add success class

        $('#product-' + id).removeClass('btn-default disabled').addClass('btn btn-success');
        
        // total price
        calculateTotal();
    });

    //change product quantity
    $('body').on('keyup change', '.product-quantity', function(){

        var quantity = Number($(this).val());

        var unitPrice = $(this).data('price');

        // var unitPrice = parseFloat($(this).html().replace(/,/g, ''));  there is an error with floating number

        $(this).closest('tr').find('.product-price').html(accounting.format(quantity * unitPrice, 2));
        
        calculateTotal();
    });

    $('.order-products').on('click', function(e){

        e.preventDefault();

        $('#order-product-list').empty();

        $('#loading').css('display', 'block');

        var url = $(this).data('url');

        var method = $(this).data('method');

        $.ajax({

            url: url,
            method: method,
            success : function(data){

                $('#loading').css('display', 'none');

                $('#order-product-list').append(data);

                $('.print-btn').css('display', 'block');

            }

        });

    });

    $('.print-btn').on('click', function(){
    
        $('#print-area').printThis();

    });

});

// Calculate Total Price Function
function calculateTotal(){

    var price = 0 ;

    $('.order-list .product-price').each(function(){

        price += parseFloat($(this).html().replace(/,/g, ''));


    });

    $('.total-price').html(accounting.formatNumber(price, 2));

    if(price){

        $('#add-order-form-btn').removeClass('disabled');

    }else{
        $('#add-order-form-btn').addClass('disabled');
    }
}