<?php
	require_once"header.php";
	require_once"connection.php";
    
    $get_categories = mysqli_query($db, "SELECT * FROM categories");
    $get_razdel = mysqli_query($db, "SELECT * FROM razdel");
    $razdels = mysqli_fetch_array($get_razdel);
    
    if(empty($_SESSION['razdel'])){ 
        $_SESSION['razdel'] = 1;
    }

    while($razdels = mysqli_fetch_array($get_razdel)){
        if($razdels['id'] == $_SESSION['razdel']) $razdel_name = $razdels['name'];
    }
?>

<div id="content">
    <div class="ochki">
        <div class="container">
            <div class="row ver">
                <h1 class="col-12"></h1>
                <ul class="col-12 nav justify-content-center" id="categories">
                    
                </ul>
            </div>
        </div>
    
        <div id="content" class="container"> 
            <div class="row" style="min-height: 100vh; margin-top:30px;">
                <div class="col-12 row">
                    <div class="col-3" id="razdels"></div>
                    <div class="col-8 row pruducts" id="pruducts"></div>
                </div>
            </div>
        </div>
    </div> 
</div>

<script>

                

$(document).ready(function(){
    
    getProduct(1,'all');
    
});

function add_cart(id){

    event.stopPropagation(); 
    event.preventDefault(); 

    // создадим объект данных формы
    var data = new FormData();

    // добавим переменную для идентификации запроса
    data.append('id', id);

    // AJAX запрос
    $.ajax({
        url         : './cartAdd.php',
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

let products = []; 
let categories = [];
let razdels = [];
function getProduct(razdel, category = 'all'){

    // создадим объект данных формы
    var data = new FormData();

    // добавим переменную для идентификации запроса
    data.append('razdel', razdel);
    data.append('category', category);

    // AJAX запрос
    $.ajax({
        url         : './catalog.php',
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
                
                products = respond.product;
                categories = respond.category;
                razdels = respond.razdel;
                filter('Оправы', 'all');
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
}

let appRazdel = '';
function filter(razdel, category = 'all'){
    let newProducts = Object.assign(products); 
    let newCategories = Object.assign(categories);

    if(razdel)
        newProducts = _.filter(newProducts, {razdel: razdel})
    appRazdel = razdel;
    
    if(category && category != 'all')
        newProducts = _.filter(newProducts, {category: category})
    
    newCategories = _.filter(newCategories, { razdel: razdel })
    
    render(newProducts, razdels, newCategories); // Отрисовуем результат
    
}

function render(products = [], razdels = [], categories = []) {
    $("#pruducts").empty()  // Очищаем контейнер
    for(let product of products) {
        $("#pruducts").append($(`
        <div class='col-4 product'>
            <a id="mypopover-${product.id}" onclick="popover(${product.id})" data-trigger="focus" data-toggle="popover" title="Описание" data-content='${product.Description}'><img src='${product.img}' class='productImg'></a>
            <div class='productDes'>
                <span>${product.Name}</span>
                <h3>${product.Price} руб.</h3>
                <hr>
                <input type='submit' id='add_cart' onclick="add_cart('${product.id}')" class="btn btn-info" value='добавить в корзину'>
            </div>
        </div>
        `));
    }
    $("#razdels").empty()
    for(let razdel of razdels){
        $("#razdels").append($(`
            <div class="razdel" onclick="filter('${razdel.name}', 'all')">
                <a href="#">${razdel.name}</a>
            </div>
        `)); 
    }
    $("#categories").empty()
    $("#categories").append($(`
        <li class="nav-item">
            <a class="nav-link active" href="#" onclick="filter('${appRazdel}')">Все</a>
        </li>  
    `));
    for(let category of categories){
        $("#categories").append($(`
            <li class="nav-item" onclick="filter('${category.razdel}','${category.name}')">
                <a class="nav-link" href="#">${category.name}</a>
            </li>
        `)); 
    }
}

function popover(id){
    $('#mypopover-'+id).popover('toggle');
}

</script>

<?php
	require_once"footer.php";
?>