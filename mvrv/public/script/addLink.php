<?php

$url = $_POST['url'];
$data = array();
$data['url'] = $url;

//phpinfo();
//exit();

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

$doc = phpQuery::newDocument($html);
$data['title'] = $doc["title"]->text();
//$data['image'] = $doc['img'];


echo 'Image Count:' . count($doc['img']) ."<br>";

echo '<label>タイトル</label>'.'<div>'.$data['title'].'</div>'."\n";
echo '<label>URL</label>'.'<div>'.$data['url'].'</div>'."\n";
echo '<label>画像</label><div>';

$n = 0;
foreach($doc['img'] as $val) {
	if($n < 10) {
		//$data['image'][] = pq($val); forjson
        
        $src = pq($val)->attr('src');
        //echo $src;
        
        if(strpos($src, '://') !== FALSE) {
        	echo pq($val) . "</div>";
        }
        else {
            //echo $url.$src;
            echo '<img src="'.$url.$src.'">' . "</div>";
        }
    }
	$n++;
}

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

