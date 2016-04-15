<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>圈子集市推图制作</title>
  <meta name="renderer" content="webkit">
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.6.1/css/amazeui.min.css">
  <link rel="stylesheet" href="./assets/simditor-2.3.6/styles/simditor.css">
  <style>.red{color:red}img{width:100%}.simditor .simditor-body img.selected{box-shadow:none}body{margin: 10px}</style>
</head>
<body>


<div class="am-g">
  <div class="am-u-md-6">
    <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
      <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active"><a href="#tab1">圈子集市推图制作</a></li>
        <li><a href="#tab2">批量制作</a></li>
      </ul>
    
      <div class="am-tabs-bd">
        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
<div class="am-u-md-12">
        <form id="one" class="am-form am-form-horizontal" method="post" action=".">
          <div class="am-form-group">
            <label class="am-u-md-3 am-form-label"><span class="red">*</span>商品链接</label>
            <div class="am-u-md-9">
              <input type="text" name="url" placeholder="如: http://wx.quanzijishi.com/item/520" required>
            </div>
          </div>
          <div class="am-form-group">
            <label class="am-u-md-3 am-form-label">封面图链接</label>
            <div class="am-u-md-9">
              <input type="text" name="theme_url" placeholder="如: http://www.baidu.com/logo.png">
              <small>若填写则将替换原封面图片</small>
            </div>
          </div>
          <div class="am-form-group">
            <label class="am-u-md-3 am-form-label">标题</label>
            <div class="am-u-md-9">
              <input type="text" name="title" placeholder="如: 冬菜助手小公仔">
              <small>若填写则将替换原标题</small>
            </div>
          </div>
          <div class="am-form-group">
            <label class="am-u-md-3 am-form-label">简介</label>
            <div class="am-u-md-9">
              <input type="text" name="des" placeholder="如: 棒棒哒">
              <small>若填写则将替换原简介</small>
            </div>
          </div>
          <div class="am-form-group">
            <label class="am-u-md-3 am-form-label">价格</label>
            <div class="am-u-md-9">
              <input type="number" name="price" placeholder="如: 10">
              <small>若填写则将替换原价格</small>
            </div>
          </div>

          <div class="am-form-group">
            <div class="am-u-md-9 am-u-md-push-3">
              <button type="submit" class="am-btn am-btn-block am-btn-primary">立即制作</button>
            </div>
          </div>
          <div class="am-form-group">
            <div class="am-u-md-9 am-u-md-push-3">
              <button type="button" class="clear-textarea am-btn am-btn-block am-btn-danger">清空复制区→</button>
            </div>
          </div>
        </form>
      </div>
        </div>
        <div class="am-tab-panel am-fade" id="tab2">
<div class="am-u-md-12">
        <form id="multi" class="am-form am-form-horizontal" method="post" action=".">
          <div class="am-form-group">
            <label for="user-intro" class="am-u-md-3 am-form-label"><span class="red">*</span>链接列表</label>
            <div class="am-u-md-9">
              <textarea id="urls" rows="15" placeholder="如:
http://wx.quanzijishi.com/item/520
http://wx.quanzijishi.com/item/521
http://wx.quanzijishi.com/item/522
..." required></textarea>
              <small>一行一条链接</small>
            </div>
          </div>
          <div class="am-form-group">
            <div class="am-u-md-9 am-u-md-push-3">
              <button type="submit" class="am-btn am-btn-block am-btn-primary">立即制作</button>
            </div>
          </div>
          <div class="am-form-group">
            <div class="am-u-md-9 am-u-md-push-3">
              <button type="button" class="clear-textarea am-btn am-btn-block am-btn-danger">清空复制区→</button>
            </div>
          </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="am-u-md-6">
      <textarea id="editor" placeholder="图片复制区"></textarea>
  </div>
</div>

<script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.min.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.6.1/js/amazeui.min.js"></script>
<script src="./assets/simditor-2.3.6/scripts/module.min.js"></script>
<script src="./assets/simditor-2.3.6/scripts/hotkeys.min.js"></script>
<script src="./assets/simditor-2.3.6/scripts/simditor.min.js"></script>
<script>
    var editor = new Simditor({
      textarea: $('#editor'),
      toolbarHidden: true
    });
    editor.insert = function(html){
        return this.setValue(html+this.getValue());
    };
    $('.clear-textarea').click(function(e){
        e.preventDefault();
        editor.setValue('');
    });
    $('#one').submit(function(e){
        e.preventDefault();
        var btn = $(this).find('button:first');
        btn.html('<i class="am-icon-spinner am-icon-pulse"></i> 制作中').addClass('am-disabled');
        $.post(this.action, $(this).serialize(), function(r){
            r = JSON.parse(r);
            editor.insert('<img src="'+r.picurl+'" style="width:100%;">');
            btn.html('立即制作').removeClass('am-disabled');
        });
    });
    $('#multi').submit(function(e){
        e.preventDefault();
        var btn = $(this).find('button:first');
        btn.html('<i class="am-icon-spinner am-icon-pulse"></i> 制作中').addClass('am-disabled');
        var _this = this;
        var urls = $('#urls').val().split(/\s+/);
        var len = urls.length;
        var i = 0;
        urls.forEach(function(url){
            $.post(_this.action, {url: url}, function(r){
                i++;
                r = JSON.parse(r);
                editor.insert('<img src="'+r.picurl+'" style="width:100%;">');
                if(i === len){
                    btn.html('立即制作').removeClass('am-disabled');
                }
            });
        });
    });
</script>
</body>
</html>