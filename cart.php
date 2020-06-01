<?php
	require_once"header.php";
    require_once"connection.php";
    
    $user = $_SESSION['id_user'];
    
    $get_cart_user = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user'");
    $cart = mysqli_fetch_array($get_cart_user);

    $products_array = explode("|", $cart['products']);
    $products_array = implode(',', $products_array);

    $sum = 0;
    $kol = 0;

    $get_products_cart = mysqli_query($db, "SELECT * FROM product WHERE id IN($products_array)");
?>

<div id="content">
    <? if($_SESSION['login'] != 'adminn') {?>
    <div class="cart">
        <div class="cart_products">
            <? if($cart['id'] != '' && !empty($_SESSION['login'])){
                while($product = mysqli_fetch_array($get_products_cart)){?>
                        <a rel="popover" data-img="<? echo $product['img'] ?>">
                            <div class="cart_product" id="product_<? echo $product['id'] ?>">
                                <span><? echo $product['Name']; ?></span>
                                <div class="price_btn">
                                    <span><? echo $product['Price']; ?> Руб.</span>
                                    <span><button class="cart_remove_btn" onclick="deleteProduct('<? echo $product['id']?> ')"><img src="./images/remove.svg"></button></span>
                                </div>
                                <? 
                                    $sum += $product['Price']; 
                                    $kol++;
                                ?>
                            </div>
                        </a>
            <?}}else{?>

                <div id="empty_cart_text">В корзине пока нет товаров.</div>

            <? } ?>
        </div>

        <? if($get_cart_user != false && !empty($_SESSION['login'])){?>
            <div class="order">
                <div class="info_order">
                    <div class="order_row">
                        <span>Количество товаров:</span> 
                        <span><span id="kol"><? echo $kol; ?></span> Шт.</span>
                    </div>
                    <div class="order_row">
                        <span>Итого:</span> 
                        <span><span id="sum"><? echo $sum; ?></span> Руб.</span>
                    </div>
                    <div class="order_row">
                        <span>Забрать заказ:</span>
                        <input id="datep"/>
                    </div>
                    <div class="order_row">
                        <span>Способ оплаты:</span>
                        <label><input type="radio" name="radio" value="nal"> Наличными</label>
                        <label><input type="radio" name="radio" value="kart"> Картой</label>
                    </div>
                </div>    
                <button class="order_btn" onclick="orderAccept()">Оформить заказ</button>
            </div>
        <?}?>
    </div>
    <? } else {
        require_once("adminPanel.php");
     } ?>
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Ошибка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_error_body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">ок</button>
            </div>
            </div>
        </div>
    </div>
</div>

<script>

    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $('#datep').datepicker({
        constrainInput: true,
        minDate: "+2",
        maxDate: "+7",
        dateFormat: 'yy-mm-dd',
        beforeShowDay: $.datepicker.noWeekends,
	});
    function deleteProduct(id){

        event.stopPropagation(); 
        event.preventDefault(); 

        var data = new FormData();
        data.append('delId', id);

        $.ajax({
            url         : './function/cartFunction.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            processData : false,
            contentType : false, 
            success     : function( respond, status, jqXHR ){
                if( typeof respond.error === 'undefined' ){
                    document.getElementById('product_' + respond.productId).remove();
                    document.getElementById('kol').textContent  -= 1;
                    document.getElementById('sum').textContent  -= respond.priceproduct;
                }
                else {
                    document.getElementById('modal_error_body').innerText = respond.error;
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }
        });
    }

    function orderAccept(){
        var pay = $('input[name="radio"]:checked').val();
        var date = $('#datep').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        var sum = document.getElementById('sum').textContent;

        event.stopPropagation(); 
        event.preventDefault(); 

        var data = new FormData();
        data.append('acceptOrder', true);
        data.append('orderDate', date);
        data.append('orderPay', pay);
        data.append('orderSum', sum);

        $.ajax({
            url         : './function/cartFunction.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            processData : false,
            contentType : false, 
            success     : function( respond, status, jqXHR ){
                if( typeof respond.error === 'undefined' ){
                    console.log(respond.status);
                    location.reload();
                }
                else {
                    document.getElementById('modal_error_body').innerText = respond.error;
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }
        });
    }

    $('a[rel=popover]').popover({
        html: true,
        trigger: 'hover',
        placement: 'bottom',
        content: function () {
            return '<img src="'+ $(this).data('img') +'" />';
        }
    });
</script>

<?php
	require_once"footer.php";
?>