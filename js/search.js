$(function(){
    
//Живой поиск
$('.who').bind("change keyup input click", function() {
    if(this.value.length >= 2){
        $.ajax({
            type: 'post',
            url: "search.php", //Путь к обработчику
            dаta: {'referal':this.value},
            response: 'text',
            success: function(data){
                $(".search_result").html(data).fadeIn(); //Выводим полученые данные в списке
           }
       })
    }
})
    
$(".search_result").hover(function(){
    $(".who").blur(); //Убираем фокус с input
})
    
//При выборе результата поиска, прячем список и заносим выбранный результат в input
$(".search_result").on("click", "li", function(){
    s_user = $(this).text();
    //$(".who").val(s_user).attr('disabled', 'disabled'); //деактивируем input, если нужно
    $(".search_result").fadeOut();
})
})