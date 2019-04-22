<!-- jquery & iScroll -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.2.0/iscroll.min.js"></script>
<!-- drawer.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/drawer/3.2.2/js/drawer.min.js"></script>
<!-- 以下のscssコンパイル方法は却下 -->
<!-- sass.js を読み込む -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sass.js/0.10.7/sass.sync.min.js"></script> -->
<!-- 本ライブラリを読み込む -->
<!-- <script src="https://unpkg.com/@neos21/in-browser-sass@1.0.2/in-browser-sass.min.js"></script> -->
<script>
  $(function() {
    $('.drawer').drawer();
  });
  
  (function($){
    function formSetDay(){
      var lastday = formSetLastDay($('.js-changeYear').val(), $('.js-changeMonth').val());
      var option = '';
      for (var i = 1; i <= lastday; i++) {
        if (i === $('.js-changeDay').val()){
          option += '<option value="' + i + '" selected="selected">' + i + '</option>\n';
        }else{
          option += '<option value="' + i + '">' + i + '</option>\n';
        }
      }
      $('.js-changeDay').html(option);
    }

    function formSetLastDay(year, month){
      var lastday = new Array('', 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
      if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0){
        lastday[2] = 29;
      }
      return lastday[month];
    }

    $('.js-changeYear, .js-changeMonth').change(function(){
      formSetDay();
    });
  })(jQuery);
</script>
</body>
</html>