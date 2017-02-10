<?php

$url = $_POST['url'];

if($url == '') {
	echo '<span class="text-danger" data-success="0">URLを入力して下さい</span>';
	exit();
}

$data = array();
$data['url'] = $url;


//No Curl -> apt-get -y install php-curl
//$ch = curl_init();
//
//// URL や他の適当なオプションを設定します
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//
//// URL を取得し、ブラウザに渡します
//$html = curl_exec($ch);
//
//// cURL リソースを閉じ、システムリソースを解放します
//curl_close($ch);

require_once('phpQuery-onefile.php');

$html = file_get_contents($url, false, stream_context_create(array(
    'http'=>array(
        'method'=>"GET",
        'header'=>"User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1",
        'ignore_errors'=>true,
    ),
)));

if($html === FALSE) {
	echo '<span class="text-danger" data-success="0">URLを取得できません</span>';;
    exit();
}


$doc = phpQuery::newDocument($html);
$data['title'] = $doc["title"]->text();
//$data['image'] = $doc['img'];

$imgCount = count($doc['img']);

$textFrame = '<span data-success="1">タイトル：</span><div>' . $data['title'].'</div>'."\n";
$textFrame .= '<span>URL：</span><div>'.$data['url'].'</div>'."\n";
echo $textFrame;

$imgFrame = '<div class="linkimg-wrap">'."\n";

$n = 1;
$bool = false;
if($imgCount > 0) {
    foreach($doc['img'] as $val) {
        if($n > 10) {
            break;
        }
        //$data['image'][] = pq($val); forjson
            
        $width = pq($val)->attr('width');
        if($width && $width < 50) {
            continue;
        }
        
        $src = pq($val)->attr('src');
        
        if(strpos($src, '://') === FALSE) {
            $src = $url.$src;
        }
        
        if($fp = fopen($src, "r")){
        
            $imgFrame .= '<img src="'.$src.'" data-count="'.$n.'">'."\n";
            //$imgFrame .= pq($val)."\n";
            $bool = true;
        }
//        else {
//            $imgFrame .= '<span class="text-danger">画像がありません</span>';
//            $bool = false;
//            break;
//        }
        
        $n++;
    }
}
$firstNum = $n > 1 ? 1 : 0;

if(!$bool) {
	echo '<span class="text-danger">画像の取得が出来ません</span>';
	exit();
}

$imgFrame .= "</div>\n";
$imgFrame .= '<div class="linksel-wrap">'."\n";
$imgFrame .= '<span>＜</span>'."\n";
$imgFrame .= '<small><em>'.$firstNum.'</em>／<em>'.($n-1).'</em></small>'."\n";
$imgFrame .= '<span>＞</span>'."\n";
$imgFrame .= '</div>'."\n";

echo $imgFrame;

//$data = json_encode($data);
//echo $data;





//function getPageTitleFromURL($url) {
//	
//    $data = array();
//    $data['url'] = $url;
//
//
////  if ($file = fopen($url, 'r')) {
//// 
////    while (!feof($file)) {
//// 
////      $line = fgets($file);
////      echo $line;
////      //exit();
//// 
//////      if (preg_match("/<title>(.*?)<\/title>/i", $line, $matches)) {
//////        // タイトル文字列にリンクを貼る
//////        $data['title'] = '<a href="' . $url . '">' . $matches[1] . '</a>';
//////        $data['aaa'] = $matches;
//////      }
//////      
//////      if (preg_match("/<legend>(.*?)<\/legend>/i", $line, $mas)) {
//////        // タイトル文字列にリンクを貼る
//////        $data['image'] = $mas[1];
//////        print_r($mas);
//////        //break;
//////      }
//// 
//////      if (preg_match("/<\/head>/i", $line)) {
//////        // headタグ内にタイトルタグが見つからなかったらループ終了
//////        break;
//////      }
////    }
////  }
//  // URLにリンクを貼る
//  //return '<a href="' . $url . '">' . htmlspecialchars($url) . '</a>';
//  return $data;
//}

//$data = getPageTitleFromURL($url);
//
//echo '<label>タイトル</label>'.'<p>'.$data['title'].'</p>'."\n";
//echo '<label>URL</label>'.'<p>'.$data['url'].'</p>'."\n";
//echo '<label>画像</label>'.'<p>'.$data['image'].'</p>'."\n";
//
//foreach($data['image'] as $val) {
//	echo '<label>画像</label>'.'<p>'.$val.'</p>'."\n";
//}
//foreach($data['aaa'] as $val) {
//	echo '<label>aaa</label>'.'<p>'.$val.'</p>'."\n";
//}

//echo $url;

