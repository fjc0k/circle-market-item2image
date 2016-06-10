<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>圈子集市推图制作</title>
  <meta name="renderer" content="webkit">
  <link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.6.1/css/amazeui.min.css">
  <link rel="stylesheet" href="http://public.dufe.cc/AmazeUI/datetimepicker/css/amazeui.datetimepicker.css">  
  <link rel="stylesheet" href="./assets/simditor-2.3.6/styles/simditor.css">
  <style>.red{color:red}img{width:100%}.simditor .simditor-body img.selected{box-shadow:none}body{margin: 10px}</style>
</head>
<body>


<div class="am-g">
  <div class="am-u-md-6">
    <div class="am-tabs" data-am-tabs="{noSwipe: 1}">
      <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active"><a href="#tab1">单图制作</a></li>
        <li><a href="#tab2">批量制作</a></li>
        <li><a href="#tab3">批量制作【按时间】</a></li>
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
        <div class="am-tab-panel am-fade" id="tab3">
          <div class="am-u-md-12">
            <form id="bytime" class="am-form am-form-horizontal" method="post" action=".">
              <div class="am-form-group">
                <label class="am-u-md-3 am-form-label"><span class="red">*</span>集市ID</label>
                <div class="am-u-md-9">
                  <input type="text" name="circle_id" placeholder="如: nf9b3dv0y4k" required>
                </div>
              </div>
              <div class="am-form-group">
                <label class="am-u-md-3 am-form-label"><span class="red">*</span>起始时间</label>
                <div class="am-u-md-9">
                  <input type="text" name="start_time" class="datetimepicker" readonly placeholder="点击选择">
                </div>
              </div>
              <div class="am-form-group">
                <label class="am-u-md-3 am-form-label"><span class="red">*</span>结束时间</label>
                <div class="am-u-md-9">
                  <input type="text" name="end_time" class="datetimepicker" readonly placeholder="点击选择">
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
<div class="am-modal am-modal-confirm" tabindex="-1" id="error-tip">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">提示</div>
    <div class="am-modal-bd" id="error-message">
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>我知道了</span>
    </div>
  </div>
</div>
<div class="am-modal am-modal-confirm" tabindex="-1" id="bytime-confirm">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">按时间批量制作</div>
    <div class="am-modal-bd">
      共有<span id="item-count"></span>条商品/服务的推图需要制作，是否继续？
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>继续</span>
    </div>
  </div>
</div>
<!-- 更新cookies -->
<img src="?m=updateCookies" style="display: none;width: 0;height: 0;margin-left: -1000px;">
<script src="http://lib.sinaapp.com/js/jquery/2.0.3/jquery-2.0.3.min.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.6.1/js/amazeui.min.js"></script>
<script src="http://public.dufe.cc/AmazeUI/datetimepicker/js/amazeui.datetimepicker.min.js"></script>
<script src="http://public.dufe.cc/AmazeUI/datetimepicker/js/locales/amazeui.datetimepicker.zh-CN.js"></script>
<script src="./assets/simditor-2.3.6/scripts/module.min.js"></script>
<script src="./assets/simditor-2.3.6/scripts/hotkeys.min.js"></script>
<script src="./assets/simditor-2.3.6/scripts/simditor.min.js"></script>
<script>
    $('.datetimepicker').datetimepicker({
      format: 'yyyy-mm-dd hh:ii',
      language:  'zh-CN'
    });
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
    $('#bytime').submit(function(e){
      e.preventDefault();
      var _this = this;
      $.post('?m=CircleItemUrls', $(_this).serialize(), function(r){
        r = JSON.parse(r);
        if(!r.success){
          $('#error-message').html(r.message);
          $('#error-tip').modal();
          return;
        }
        $('#item-count').html(r.urls.length);
        $('#bytime-confirm').modal({
          relatedTarget: r.urls, // 数据钩子 以更新modal中的动态数据
          onConfirm: function() {
            var btn = $(_this).find('button:first');
            btn.html('<i class="am-icon-spinner am-icon-pulse"></i> 制作中').addClass('am-disabled');
            var urls = this.relatedTarget;
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
          },
          onCancel: function() {}
        });
      });
    });
</script>
</body>
</html>