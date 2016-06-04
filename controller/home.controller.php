<?php namespace Controller;

use Intervention\Image\ImageManagerStatic as Image;
use Endroid\QrCode\QrCode;
use Funch\Curl;

class Home{

    private $config = [];

    function __construct(){
        $this->config = include('./config.php');
    }

    function index(){
        $now = time();
        // 删除超过1个小时的图片缓存
        $cache_images_path = './cache/images';
        $files = glob($cache_images_path.'/*');
        foreach ($files as $file) {
            if(filemtime($file) < $now - 3600){
                unlink($file);
            }
        }
        // 删除超过24小时的url列表缓存
        $cache_items_path = './cache/items';
        $files = glob($cache_items_path.'/*');
        foreach ($files as $file) {
            if(filemtime($file) < $now - 3600*24){
                unlink($file);
            }
        }
        return view('home.index');
    }
    
    private function circleItemUrls($circle_id, $start_time, $end_time){
        $body = Curl::request([
            'url' => 
                'http://api.quanzijishi.com/internal/get_circle_item_urls?circle_id='.$circle_id,
            'headers' => 
                'Content-Type: application/json',
            'post' => 
                json_encode([
                    'password' => $this->config['token'],
                    'start_time' => $start_time,
                    'end_time' => $end_time
                ])
        ]);

        $ret = json_decode($body, true);
        if(!$ret || $ret['status_code'] != 200)
            return [];
        else
            return $ret['urls'];

    }

    public function postCircleItemUrls(){
        $circle_id = $_POST['circle_id'];
        $start_time = strtotime($_POST['start_time']);
        $end_time = strtotime($_POST['end_time']);
        $cache_name = md5($circle_id.$start_time.$end_time);
        $cache_file = './cache/items/'.$cache_name;
        $fake_urls = [];
        if(file_exists($cache_file)){
            $urls = unserialize(file_get_contents($cache_file));
            $count = count($urls);
            for($i = 0; $i < $count; $i++){
                $fake_urls[] = 'fake_'.$cache_name.'_'.$i;
            }
            return ajax([
                'success' => true,
                'urls' => $fake_urls
            ]);
        }
        $urls = $this->circleItemUrls($circle_id, $start_time, $end_time);
        if(!$urls){
            return ajax([
                'success' => false,
                'message' => '该时段无商品！'
            ]);
        }
        $count = count($urls);
        if($count > $this->config['item_urls_limit']){
            return ajax([
                'success' => false,
                'message' => '该时段商品/服务数（共'.$count.'个）过多（限制：'.$this->config['item_urls_limit'].'个），请分开制作！'
            ]);
        }
        file_put_contents($cache_file, serialize($urls));
        for($i = 0; $i < $count; $i++){
            $fake_urls[] = 'fake_'.$cache_name.'_'.$i;
        }
        return ajax([
            'success' => true,
            'urls' => $fake_urls
        ]);

    }

    private function realUrl($fake_url){
        $t = explode('_', $fake_url, 3);
        $urls = unserialize(file_get_contents('./cache/items/'.$t[1]));
        return $urls[$t[2]];
    }

    function postIndex(){
        $url = explode('?', trim($_POST['url']), 2)[0];
        if(substr($url, 0, 4) === 'fake'){ // fake_url转真实url
            $url = $this->realUrl($url);
        }
        $headers = 'Cookie: user_id='.$this->config['user_id'].'; session='.$this->config['session'];
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

        $des = isset($_POST['des']) && $_POST['des'] ? $_POST['des'] : (strpos($body, '<pre id="description">') !== false ? trim($substr($body, '<pre id="description">', '</pre>')) : '<(￣︶￣)> 假装有介绍');
        $des = $removeEmoji($des);
        $des = mb_strlen($des, 'utf-8') <= 26 ? $des : mb_substr($des, 0, 26, 'utf-8').'...';
        
        $first_picture_url = isset($_POST['theme_url']) && $_POST['theme_url'] ? $_POST['theme_url'] : $substr($body, '<img class="photo" src="', '"');

        $price = isset($_POST['price']) && $_POST['price'] ? '￥'.$_POST['price'] : $substr($body, 'price">', '</span>'); // 已适配特殊价格
        
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