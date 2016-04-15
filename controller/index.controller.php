<?php namespace Controller;

use Intervention\Image\ImageManagerStatic as Image;
use Endroid\QrCode\QrCode;
use Funch\Curl;

class Index{
    
    function index(){
        // 删除超过1个小时的图片缓存
        $cache_images_path = './cache/images';
        $files = glob($cache_images_path.'/*');
        foreach ($files as $file) {
            if(filemtime($file) < time() - 3600){
                unlink($file);
            }
        }
        return view('index');
    }
    
    function postIndex(){
        $config = include('./config.php');
        $url = explode('?', trim($_POST['url']), 2)[0];
        $headers = 'Cookie: session='.$config['session'];
        $body = Curl::request([
            'url' => $url,
            'headers' => $headers
        ]);
        
        // 处理函数
        $substr = function($str, $start, $end){ // 截取
            $str = explode($start, $str, 2);
            $str = explode($end, end($str), 2);
            $str = html_entity_decode($str[0]);
            $str = str_replace(["\r", "\n"], '', trim(strip_tags($str)));
            return $str;
        };
        $removeEmoji = function($str){ // 去除emoji
            return preg_replace('/[\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]/u', '', $str);
        };

        $type_title = explode('·', $substr($body, '<title>', '</title>'), 2);

        $title = isset($_POST['title']) && $_POST['title'] ? $_POST['title'] : $type_title[1];
        $title = $removeEmoji($title);
        $title = mb_strlen($title, 'utf-8') <= 18 ? $title : mb_substr($title, 0, 18, 'utf-8').'...';

        $des = isset($_POST['des']) && $_POST['des'] ? $_POST['des'] : trim($substr($body, '<pre id="description">', '</pre>'));
        $des = $removeEmoji($des);
        $des = mb_strlen($des, 'utf-8') <= 26 ? $des : mb_substr($des, 0, 26, 'utf-8').'...';
        
        $first_picture_url = isset($_POST['theme_url']) && $_POST['theme_url'] ? $_POST['theme_url'] : $substr($body, '<img class="photo" src="', '"');
        
        $price = isset($_POST['price']) && $_POST['price'] ? '￥'.$_POST['price'] : $substr($body, '<span class="price">', '</span>');
        
        $type = $type_title[0] === '我有' ? 'product' : 'service';
        
        
        // 画板宽高
        $width = 780;
        $height = 1100;
        // 封面宽高
        $theme_width = $width;
        $theme_height = 550;
        // 字体
        $font_file = './assets/msyh.ttc';
        
        // 主图
        $img = Image::canvas($width, $height, '#ffffff');
                    
        // 插入封面
        $theme = Image::make($first_picture_url);
        $theme->fit($theme_width, $theme_height);
        $img->insert($theme, 'top');
        // 插入类别标签
        $img->insert('./assets/'.$type.'.jpg', 'top-left', 0, $theme_height - 100);
        // 插入标题
        $img->text($title, $width/2, 620, function($font) use($font_file){
            $font->file($font_file);
            $font->size(38);
            $font->color('#000000');
            $font->align('center');
            // $font->valign('middle');
        });
        // 插入描述
        $img->text($des, $width/2, 660, function($font) use($font_file){
            $font->file($font_file);
            $font->size(26);
            $font->color('#646464');
            $font->align('center');
            $font->valign('middle');
        });
        // 插入价格
        $img->text($price, $width/2, 730, function($font) use($font_file){
            $font->file($font_file);
            $font->size(35);
            $font->color('#ff0000');
            $font->align('center');
            $font->valign('middle');
        });
        // 插入二维码
        $qrcode = new QrCode();
        $qr_image = $qrcode
                    ->setText($url)
                    ->setSize(200)
                    ->setPadding(10)
                    ->setErrorCorrection('high')
                    ->setForegroundColor(['r' => 149, 'g' => 149, 'b' => 149, 'a' => 0])
                    ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
                    ->setLabelFontSize(16)
                    ->getImage();
        $img->insert($qr_image, 'top', 0, 770);
        // 插入提示
        $img->text("▲", $width/2, 1015, function($font) use($font_file, $type){
            $font->file($font_file);
            $font->size(24);
            $font->color(($type === 'service' ? '#49C8A6' : '#FF7B86'));
            $font->align('center');
            $font->valign('middle');
        });
        $img->text("长按识别二维码，查看详情", $width/2, 1050, function($font) use($font_file){
            $font->file($font_file);
            $font->size(24);
            $font->color('#646464');
            $font->align('center');
            $font->valign('middle');
        });
        // 插入shadow
        $img->insert('./assets/shadow.jpg', 'bottom');
        // 保存图片
        $save_path = './cache/images/'.time().rand(0, 1000).uniqid().'.png';
        $img->save($save_path, 50);
        return ajax([
            'picurl' => $save_path
        ]);
        
    }
    
    
}