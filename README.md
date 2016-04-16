# 圈子集市推图制作
PHP版的圈子集市推图制作工具, 可以将圈子集市的商品或服务生成为图片卡片, 方便微信公众号的推送.

## 安装要求

- PHP >=5.6 (最佳: PHP7)
- 以下扩展必须安装: Fileinfo、GD（或Imagick）、mbstring

## 使用之前
- 配置session, 编辑config.php, 如:
```php
<?php
return [
    'session' => '.eJw3324g213G7zNpFYWZa4DKk_N321Ji3322L4v70MRSK3N-3NNG020KAO45664hHERC2oRB48uqwITDdCqbinudi1bXlc2N7ulPWSV0v134ejD83442.CeVn3w7lv44Ubi0vmpYofURyTc-_Y'
    // 该session为随意填写, 请不要直接复制粘贴
];
```
- 更改cache目录权限为777.

任何建议, 加微信: ifunch
