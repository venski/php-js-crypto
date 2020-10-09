<!DOCTYPE html>
<html lang="en">
<head>
<title>测试2</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel='stylesheet' type="text/css" href="css/nprogress.css"/>
</head>
<body>
<a hfef="read.php?f=index.php">主页</a>
<a hfef="read.php?f=my.php">访问mypage</a>
<div id="loadwrap">
在这里重载内容，我是my，注意相关js或css也应该在loadwrap定义内
</div>
<script src='js/jquery.min.js'></script>
<script src="js/crypto-js/crypto-js.js"></script>
<script src="js/crypto-js/aes.js"></script>
<script src="js/jquery.pjax.js"></script>
<script src='js/nprogress.js'></script>
<script type="text/javascript">
//jquery.pjax.js
$(document).pjax('a[target!=_blank]', '#loadwrap',{
    type:'post',
    scrollTo:false,
    fragment: '#loadwrap',
    timeout: 8000
});
$(document).on('pjax:start', function() { NProgress.start(); });
$(document).on('pjax:end',   function() { NProgress.done();  });
$(document).on('pjax:click', function() {
    enable_loading = false;
})
$(document).on('pjax:send', function(){
    var str = "<p class='tc mt-10'>加载中...</p>";
    $(".loading").css("display", "block");
    $('#loadwrap').html(str);
})
$(document).on('pjax:complete', function() {
    //回调函数
    $("img[src$=jpg],img[src$=jpeg],img[src$=png],img[src$=gif]").parent("a[class!=noview]").addClass("swipebox");
    if( $('pre').length ){ prettyPrint(); } 
    //回调函数解决文章页代码不高亮的问题
    $(".loading").css("display", "none");
    //pjax加载结束的回调函数 解决js无法定位的问题
    //重新定位容器内容的函数写在这里
});
//清除过期缓存
if (!!window.localStorage) {
    for (var key in localStorage) {
        try {
            if ((key.split("_") || [""])[0] === "pjax") {
                var item = localStorage.getItem(key);
                if (item) {
                    item = JSON.parse(item);
                    if ((parseInt(item.time) + 600 * 1000) <= new Date * 1) {
                        localStorage.removeItem(key)
                    }
                }
            }
        } catch (e) { }
    }
}
</script>
</body>
</html>
