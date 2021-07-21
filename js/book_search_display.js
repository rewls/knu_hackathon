var result_html = "";
var PreviousBook="";
var BookLocData = "";

/* function SearchBookLoc(BookID){
    console.log(BookID);
    $.ajax({
      url:'/book_location.php',
      type:'GET',
      data:{id:BookID},
      success:function(data){
        data = JSON.parse(data);
        console.log(data);
        return data;
      }
    });
} */

function Search(cnt){
  var max_int = 20;
  var ParsedData = "";
  if($(".search_bar>input").val()==""){
    alert("검색어를 입력해주세요");
    return;
  }
  if (PreviousBook != $(".search_bar>input").val()){
    result_html = "";
  }
  var type = $(".drop_result").text();
  var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
  PreviousBook = $(".search_bar>input").val()
  $.ajax({
    url:'/book_search.php',
    type:'POST',
    data:{type:type_arr[type],
      name:$(".search_bar>input").val(),
      max:20,
      offset:cnt*max_int},
      success:function(data){
      ParsedData = JSON.parse(data);
      var temp_imagechecker = '';
      for(var i=0;i<ParsedData.list.length;i++){
        temp_imagechecker = ParsedData.list[i].imgUrl ? ParsedData.list[i].imgUrl : "img/NoUrl.jpg"
        result_html = result_html + '<div class="info-box">'+
      '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+ParsedData.list[i].title+'">'
        +'<span class="material-icons check-icon">star_border</span>'
        +'<div>'
          +'<span class="book-title"> '+ParsedData.list[i].title+' </span>'
          +'<span class="book-author"> '+ParsedData.list[i].author+' / '+ParsedData.list[i].publication+' </span>'
          +'<span class="material-icons">room</span>'
          +'<span class="book-status"> 4층 자연과학자료실 / 대출 가능 </span>'
          +'<span class="book-detail"> [ 상세 정보 ] </span>'
        +'</div>'
      +'</div>';
      }
      if (ParsedData.list.length < max_int){
        $("#contents").html(result_html);
      }
      else{
        $("#contents").html(result_html+'<p style="margin-top: 20px;"><div id="more" style="text-align:center;"><strong onclick="Search('+cnt+1+')" style="cursor:pointer">더보기</strong></div></p>');
      }
      $(".book-title").click(function(){
        $(this).parent('div').toggleClass("full");
      });
    }
  })
}
/*
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
            BookLocData = SearchBookLoc(SearchData.list[i].id)
            //console.log(BookLocData);
            temp_imagechecker = SearchData.list[i].imgUrl ? SearchData.list[i].imgUrl : "img/NoUrl.jpg"
            result_html = result_html + '<div class="info-box">'+
            '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+SearchData.list[i].title+'">'
              +'<span class="material-icons check-icon">star_border</span>'
              +'<div>'
                +'<span class="book-title"> '+SearchData.list[i].title+' </span>'
                +'<span class="book-author"> '+SearchData.list[i].author+' / '+SearchData.list[i].publication+' </span>'
                +'<span class="material-icons">room</span>'
                +'<span class="book-status"> '+BookLocData.list[0].location+' / '+BookLocData.list[0].state+' </span>'
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
            BookLocData = SearchBookLoc(SearchData.list[i].id)
            j += 1
            temp_imagechecker = SearchData.list[i].imgUrl ? SearchData.list[i].imgUrl : "img/NoUrl.jpg"
            result_html = result_html + '<div class="info-box">'+
            '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+SearchData.list[i].title+'">'
              +'<span class="material-icons check-icon">star_border</span>'
              +'<div>'
                +'<span class="book-title"> '+SearchData.list[i].title+' </span>'
                +'<span class="book-author"> '+SearchData.list[i].author+' / '+SearchData.list[i].publication+' </span>'
                +'<span class="material-icons">room</span>'
                +'<span class="book-status"> '+BookLocData.list.location+' / '+BookLocData.list.state+' </span>'
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
*/
