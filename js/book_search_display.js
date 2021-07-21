var result_html = "";
var PreviousBook="";
var Lib = "";
var SearchBookLoc = function(BookID){
    //console.log(Lib);
    var BookLocData = "";
    var ShelfNum = ""
    var BookCode = ""
    $.ajax({
      url:'/book_location.php',
      async:false,
      type:'GET',
      data:{id:BookID},
      success:function(data){
        data = JSON.parse(data);
        //console.log(BookID);
        //if data
        if (data.isJungDo == false){
          $("#DetailLoc").html("중앙도서관에 없습니다.");
        }
        else{
          //console.log(data.list[0].location);
          BookLocData = data.list[0].location; //0은 중도 1은 상주 근데 차피 상주는 표시X
          ShelfNum = data.list[0].shelf;
          BookCode = data.list[0].code;
          $("#DetailLoc").html("책 위치: "+BookLocData+"<br>서고 번호: "+ShelfNum+"<br>도서 코드: "+BookCode);
          BookLocData = ""; ShelfNum = ""; BookCode = "";
        }
      }
    });
}

function Search(cnt){
  var max_int = 20;
  var ParsedData = "";
  if($(".search_bar>input").val()==""){
    alert("검색어를 입력해주세요");
    return;
  }
  if (PreviousBook != $(".search_bar>input").val() || cnt == 0){
    result_html = "";
  }
  var type = $(".drop_result").text();
  var type_arr={전체:"all",제목:"title",저자:"author",출판사:"publisher"};
  PreviousBook = $(".search_bar>input").val()
  $.ajax({
    url:'/book_search.php',
    async:false,
    type:'POST',
    data:{type:type_arr[type],
      name:$(".search_bar>input").val(),
      max:20,
      offset:cnt*max_int},
      success:function(data){
      ParsedData = JSON.parse(data);
      var temp_imagechecker = '';
      for(var i=0;i<ParsedData.list.length;i++){
        Lib = ParsedData.list[i].location;
        temp_imagechecker = ParsedData.list[i].imgUrl ? ParsedData.list[i].imgUrl : "img/NoUrl.jpg"
        result_html = result_html + '<div class="info-box">'+
      '<img class="book-img" src="'+ temp_imagechecker +'" alt="'+ParsedData.list[i].title+'">'
        +'<span id="" class="check-icon"></span>'
        +'<div>'
          +'<span class="book-code"> '+ParsedData.list[i].code+' </span>'
          +'<span class="book-title"> '+ParsedData.list[i].title+' </span>'
          +'<span class="book-author"> '+ParsedData.list[i].author+' / '+ParsedData.list[i].publication+' </span>'
          +'<span class="material-icons">room</span>'
          +'<span class="book-status"> '+ParsedData.list[i].location+' / '+ParsedData.list[i].state+' </span>'
          +'<span class="book-detail" onclick="showPopup('+ParsedData.list[i].id+')"> [ 상세 정보 ] </span>'
        +'</div>'
      +'</div>';
      if (Lib==null){
        result_html = result_html.replace('<span class="book-detail" onclick="showPopup('+ParsedData.list[i].id+')"> [ 상세 정보 ] </span>', '');
      }
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

function showPopup(n) {
  const popup = document.querySelector('#popup');
  popup.classList.remove('multiple-filter');
  popup.classList.remove('hide');
  SearchBookLoc(n);
}

function closePopup() {
  const popup = document.querySelector('#popup');
  popup.classList.add('hide');
}
