<? 
    $get_orders = mysqli_query($db, "SELECT * FROM orders WHERE status = 'в процессе' OR status = 'ожидается'");
    $get_orders_success = mysqli_query($db, "SELECT * FROM orders WHERE status = 'завершено'");
?>

<div class="admin_panel">
    <div class="admin_orders">
        <div class="orders_loop" id="progress">
            <? while($order = mysqli_fetch_array($get_orders)){ 
                $products_array = explode("|", $order['products']);
                $products_array = implode(',', $products_array);
        
                $get_products_order = mysqli_query($db, "SELECT * FROM product WHERE id IN($products_array)");
            ?>
                <div class="order">
                    <div class="order_info">
                        <span class="order_num">Заказ № <? echo $order['id']; ?></span>
                        <span>Статус заказа: <? echo $order['status']; ?></span>

                    </div>
                    <div class="order_user">
                        <span>Клиент:</span>
                        <span class="order_user"><? echo $order['user']; ?></span><br>
                        <span>Телефон: <? echo $order['phone']; ?></span><br>
                        <span>Дата выдачи: <? echo $order['date']; ?></span>
                    </div>
                    
                    <span>Состав заказа:</span><br>
                    <div class="order_products" >
                        <? while($pruduct = mysqli_fetch_array($get_products_order)){ ?>
                            <a rel="popover" data-img="<? echo $pruduct['img'] ?>"><div class="order_row">
                                <span><? echo $pruduct['Name']; ?> * 1 шт.</span>
                                <span><? echo $pruduct['Price']; ?> Руб.</span>
                            </div></a>
                        <? } ?>
                        <div class="order_row sum">
                            <span>Итого:</span>
                            <span><? echo $order['sum']; ?> Руб.</span>
                        </div>
                        <div class="order_row admin_order_buttons">
                            <? if($order['status'] == 'ожидается'){ ?>
                                <button class="news_add_btn admin_order_btn" onclick="ordersAccept('<? echo $order['id']; ?>','accept')">Приступить</button>
                            <?}elseif($order['status'] == 'в процессе'){?>
                                <button class="news_add_btn admin_order_btn" onclick="ordersAccept('<? echo $order['id']; ?>','success')">Завершить заказ</button>
                            <?}?>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>

        <div class="orders_loop" id="success">
            <? while($order = mysqli_fetch_array($get_orders_success)){ 
                $products_array = explode("|", $order['products']);
                $products_array = implode(',', $products_array);
        
                $get_products_order = mysqli_query($db, "SELECT * FROM product WHERE id IN($products_array)");
            ?>
                <div class="order">
                    <div class="order_info">
                        <span class="order_num">Заказ № <? echo $order['id']; ?></span>
                        <span>Статус заказа: <? echo $order['status']; ?></span>

                    </div>
                    <div class="order_user">
                        <span>Клиент:</span>
                        <span class="order_user"><? echo $order['user']; ?></span><br>
                        <span>Телефон: <? echo $order['phone']; ?></span><br>
                        <span>Дата выдачи: <? echo $order['date']; ?></span>
                    </div>
                    
                    <span>Состав заказа:</span><br>
                    <div class="order_products">
                        <? while($pruduct = mysqli_fetch_array($get_products_order)){ ?>
                            <a rel="popover" data-img="<? echo $pruduct['img'] ?>"><div class="order_row">
                                <span><? echo $pruduct['Name']; ?> * 1 шт.</span>
                                <span><? echo $pruduct['Price']; ?> Руб.</span>
                            </div></a>
                        <? } ?>
                        <div class="order_row sum">
                            <span>Итого:</span>
                            <span><? echo $order['sum']; ?> Руб.</span>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>

        <div class="orders_btn">
            <button class="adminpanel_orders_btn" onclick="getOrders('завершено')">Завершенные заказы</button>
            <button class="adminpanel_orders_btn" onclick="getOrders('в процессе')">Актуальные заказы</button>
        </div>
        
    </div>

    <div class="admin_buttons">
        <button class="news_add_btn" data-toggle="modal" data-target="#myModalNews">
            Добавить запись
        </button>

        <button class="news_add_btn" data-toggle="modal" data-target="#myModalProduct">
            Добавить товар
        </button>
    </div>
    

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
    <div class="modal fade" id="myModalNews" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" id="headModal">
					<span style="margin: 0 auto;">Добавление новостей</span>
				</div>
				<div class="modal-body">
					<form action="" class="modalForm" id="newsForm">
						<input id="news_name" required type="text" name="name" placeholder="Название"><br>
						<textarea id="news_value" required class="text_news" name="value" placeholder="Соддержание"></textarea><br>
						<input type="date" required name="date" id="news_date"><br>
						<input class="file_input" required type="file" name="img" multiple="multiple" accept="image/*"><br>
						<input type="submit" id="news_btn" onclick="addNews()" name="submit" value="Сохранить">
					</form>
				</div>
			</div>
		</div>
    </div>

    <? $get_razdels = mysqli_query($db, "SELECT * FROM razdel"); ?>

    <div class="modal fade" id="myModalproduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="headModal">
                    <span style="margin: 0 auto;">Добавление товаров</span>
                </div>
                <div class="modal-body">
                    <form action="" class="modalForm" id="productForm">
                        <input id="glasses_name" type="text" required name="name" placeholder="Название"><br>
                        <textarea id="glasses_description" required class="text_news" name="value" placeholder="Соддержание"></textarea><br>
                        <input type="number" required placeholder="Цена" name="price" id="glasses_price"><br>
                        <input class="file_input" required type="file" name="img" multiple="multiple" accept="image/*"><br>
                        <select name="razdel" required id="glasses_razdels">
                            <? while($razdel = mysqli_fetch_array($get_razdels)){?>
                                <option value="<? echo($razdel['name'])?>"><? echo($razdel['name']) ?></option>
                            <?}?>
                        </select><br>
                        <select name="category" required id="glasses_categories">
                            
                        </select><br>
                        <input type="submit" id="product_btn" onclick="addProduct()" name="submit" value="Сохранить">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#glasses_razdels').change(function(){
        let data = new FormData();

        let razdel = $('#glasses_razdels').val();

        data.append('razdel', razdel);
        data.append('status', 'getCategory');

        $.ajax({
            url         : './function/orderFunction.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            // функция успешного ответа сервера
            success     : function( respond, status, jqXHR ){
                // ОК - файлы загружены
                if( typeof respond.error === 'undefined' ){
                    console.log(respond.status);

                    $("#glasses_categories").empty()  // Очищаем контейнер
                    for(let category of respond.categories) {
                        $("#glasses_categories").append($(`
                            <option value="${category.name}">${category.name}</option>
                        `));
                    }
                }
                // ошибка
                else {
                    document.getElementById('modal_error_body').innerText = respond.error;
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }

        });

    }).change();

    var files;

    $('.file_input').on('change', function(){
        files = this.files;
    });

    function addNews(){

        event.stopPropagation(); 
        event.preventDefault(); 

        if( typeof files == 'undefined' ) return;

        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            data.append( key, value );
        });

        // добавим переменную для идентификации запроса
        var name = $('#news_name').val();
        var value = $('#news_value').val();
        var date = $('#news_date').val();
        data.append('name', name);
        data.append('value', value);
        data.append('date', date);

        // AJAX запрос
        $.ajax({
            url         : './newsAdd.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            // функция успешного ответа сервера
            success     : function( respond, status, jqXHR ){
                // ОК - файлы загружены
                if( typeof respond.error === 'undefined' ){
                    $('#myModalNews').modal('hide');
                    files = null;
                }
                // ошибка
                else {
                    document.getElementById('modal_error_body').innerText = respond.error;
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }

        });

    };

    $('.file_input').on('change', function(){
        files = this.files;
    });

    function addProduct(){

        event.stopPropagation(); 
        event.preventDefault(); 

        if( typeof files == 'undefined' ) return;

        // создадим объект данных формы
        var data = new FormData();

        // заполняем объект данных файлами в подходящем для отправки формате
        $.each( files, function( key, value ){
            data.append( key, value );
        });

        // добавим переменную для идентификации запроса
        var name = $('#glasses_name').val();
        var description = $('#glasses_description').val();
        var price = $('#glasses_price').val();
        var razdel = $('#glasses_razdels').val();
        var category = $('#glasses_categories').val();
        data.append('name', name);
        data.append('description', description);
        data.append('price', price);
        data.append('razdel', razdel);
        data.append('category', category);

        // AJAX запрос
        $.ajax({
            url         : './glassesAdd.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            // функция успешного ответа сервера
            success     : function( respond, status, jqXHR ){
                // ОК - файлы загружены
                if( typeof respond.error === 'undefined' ){
                    $('#myModalproduct').modal('hide');
                    files = null;
                }
                // ошибка
                else {
                    document.getElementById('modal_error_body').innerText = 'Во время запроса произошла ошибка попробуйте снова.';
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }
        });
    };

    function ordersAccept(id, status){

        // создадим объект данных формы
        var data = new FormData();

        // добавим переменную для идентификации запроса
        data.append('status', status);
        data.append('orderId', id);

        // AJAX запрос
        $.ajax({
            url         : './function/orderFunction.php',
            type        : 'POST',
            data        : data,
            cache       : false,
            dataType    : 'json',
            processData : false,
            contentType : false, 
            success     : function( respond, status, jqXHR ){
                // ОК - файлы загружены
                if( typeof respond.error === 'undefined' ){
                    console.log(respond.status);
                    location.reload();
                }
                // ошибка
                else {
                    document.getElementById('modal_error_body').innerText = 'Во время запроса произошла ошибка попробуйте снова.';
                    $('#errorModal').modal('show');
                    console.log(respond.error);
                }
            },
            // функция ошибки ответа сервера
            error: function( jqXHR, status, errorThrown ){
                console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
            }
        });
    } 

    function getOrders(status){
        if(status === 'в процессе'){
            $('#success').hide();
            $('#progress').show();
        }else{
            $('#success').show();
            $('#progress').hide();
        }
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