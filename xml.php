<?php
$headerc="<?xml version='1.0'  encoding='utf-8' ?>
<!-- generator='Cyril Pblog' -->
<rss version='2.0'  xmlns:atom='http://www.w3.org/2005/Atom'>
    <channel>
        <title>Cyril IS 的博客</title>
        <description>欢迎光临 ! </description>
        <link>http://Cyrilis.com</link>
        <lastBuildDate>".date(DATE_RSS)."</lastBuildDate>
        <generator>Cyrilis.com</generator>
		<atom:link href='http://cyrilis.com/rss.xml' rel='self' type='application/rss+xml' />
        <language>zh-cn</language>
        <copyright>Copyright 2012 Cyrilis.com. All Rights Reserved.</copyright>
        <pubDate>".date(DATE_RSS)."</pubDate>";
$middlec="";
		//---->载入内容>
		  //文章索引:
require("simple_html_dom.php");
function get_files($dir) {
	$files = array();
	for (; $dir->valid(); $dir->next()) {
		if ($dir->isDir() && !$dir->isDot()) {
			if ($dir->haschildren()) {
				$files =get_files($dir->getChildren());
			};
		}else if($dir->isFile()){
			$files[] = $dir->getBaseName();
		}
	}
	return array_reverse($files);
}
$path = "./blog";
$dir = new RecursiveDirectoryIterator($path);
$indexs=get_files($dir);
rsort($indexs,SORT_NUMERIC);
	//文章索引end
 		// 开始循环----->
  //输出内容----->
		$a=0;
		foreach($indexs as $page){
			$a++;
			$html=file_get_html("./blog/".$page);
			foreach($html->find('body') as $e)
			{
				if(preg_match('/\d+/',$page)){
					//开始创建rss
					$pagelink="http://cyrilis.com/".$page;
					$pagetitle=$e->find('h1', 0)->innertext;
					//创建rss 结束. 
					//开始创建rss.
					$pagecontent=$e->innertext;
					$dateyear=substr($page,0,4);
					$datemon=substr($page,4,2);
					$dateday=substr($page,6,2);
					$middlen="<item>
					<title>".$pagetitle."</title>
					<link>".$pagelink."</link>
					<description><![CDATA[".$pagecontent."]]></description>
					<author>houshoushuai@gmail.com(Cyril Hou)</author>
					<comments>".$pagelink."#disqus_thread</comments>
					<pubDate>".date(DATE_RSS,mktime(11,11,11,$datemon,$dateday,$dateyear))."</pubDate>
					<guid>".$pagelink."</guid>
					</item>";
					$middlec=$middlec.$middlen;
					if($a==10)
					{
						break 2;
					}
				}
				else{
				continue;
				}
			}
		}
	//<-----首页结束
$footerc= "</channel></rss>";


$xmlcontent=$headerc.$middlec.$footerc;

$file="rss.xml";
$handle=fopen($file,"w");
fwrite($handle,$xmlcontent);
fclose($handle);
echo "生成成功 点击查看: <a href='rss.xml'>RSS链接</a>";
?>