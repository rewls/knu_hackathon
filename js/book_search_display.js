var result_html = "";
var SearchData = "";
var firstBook="";
var j = 20;

function FirstSearch(){
    if($(".search_bar>input").val()==""){
      alert("검색어를 입력해주세요");
      return;
    }
    if (firstBook != $(".search_bar>input").val()){
      result_html = "";
    }
    var type = $(".drop_result").text();
    var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
    firstBook = $(".search_bar>input").val()
    $.ajax({
      url:'/book_search.php',
      type:'POST',
      data:{type:type_arr[type],
        name:$(".search_bar>input").val(),
        max:20,
        offset:0},
        success:function(data){
          SearchData = JSON.parse(data);
          var temp_imagechecker = '';
          for(var i=0;i<SearchData.list.length;i++){
            temp_imagechecker = SearchData.list[i].imgUrl ? SearchData.list[i].imgUrl : "img/NoUrl.jpg"
            result_html = result_html + '<div class="info-box">'+
            '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+SearchData.list[i].title+'">'
              +'<span class="material-icons check-icon">star_border</span>'
              +'<div>'
                +'<span class="book-title"> '+SearchData.list[i].title+' </span>'
                +'<span class="book-author"> '+SearchData.list[i].author+' / '+SearchData.list[i].publication+' </span>'
                +'<span class="material-icons">room</span>'
                +'<span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>'
                +'<span class="book-detail"> [ 상세 정보 ] </span>'
              +'</div>'
            +'</div>';
          }
          if (SearchData.list.length < 20){
            $("#contents").html(result_html);
          }
          else{
            $("#contents").html(result_html+'<p style="margin-top: 20px;"><div id="more" style="text-align:center;"><strong onclick="SearchMore('+i+')" style="cursor:pointer">더보기</strong></div></p>');
          }
          $(".book-title").click(function(){
            $(this).parent('div').toggleClass("full");
          });
        }
    })
}

function SearchMore(cnt){
    if (firstBook != $(".search_bar>input").val()){
      result_html = "";
      j = 0
    }
    var type = $(".drop_result").text();
    var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
    firstBook = $(".search_bar>input").val();
    $.ajax({
      url:'/book_search.php',
      type:'POST',
      data:{type:type_arr[type],
        name:$(".search_bar>input").val(),
        max:20,
        offset:cnt},
        success:function(data){
          SearchData = JSON.parse(data);
          var temp_imagechecker = '';
          for(var i=0; i<20; i++){
            j += 1
            temp_imagechecker = SearchData.list[i].imgUrl ? SearchData.list[i].imgUrl : "img/NoUrl.jpg"
            result_html = result_html + '<div class="info-box">'+
            '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+SearchData.list[i].title+'">'
              +'<span class="material-icons check-icon">star_border</span>'
              +'<div>'
                +'<span class="book-title"> '+SearchData.list[i].title+' </span>'
                +'<span class="book-author"> '+SearchData.list[i].author+' / '+SearchData.list[i].publication+' </span>'
                +'<span class="material-icons">room</span>'
                +'<span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>'
                +'<span class="book-detail"> [ 상세 정보 ] </span>'
              +'</div>'
            +'</div>';
          }
          $("#contents").html(result_html+'<p style="margin-top: 20px;"><div id="more" style="text-align:center;"><strong onclick="SearchMore('+j+')" style="cursor:pointer">더보기</strong></div></p>');
          $(".book-title").click(function(){
            $(this).parent('div').toggleClass("full");
          });
        }
    });
}
