# 圈子集市推图制作
PHP版的圈子集市推图制作工具, 可以将圈子集市的商品或服务生成为图片卡片, 方便微信公众号的推送.

## 安装要求

- PHP >=5.6 (最佳: PHP7)
- 以下扩展必须安装: Fileinfo、GD（或Imagick）、mbstring

## 使用之前
- 配置session和圈子集市api token, 编辑config.php, 如:
```php
<?php
return [
    'session' => 'xxxxx', //该session为随意填写, 请不要直接复制粘贴
    'token' => 'xxxxxx', //你的api token
    'item_urls_limit' => 40, // 按时间制作推图时的URL数最高限制
];
```
- 更改cache下的所有子目录的权限为777.

任何建议, 加微信: ifunch
