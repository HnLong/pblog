<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-cn">
<head>
<title>Cyril IS 博客</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Cyril" />
<meta name="keywords" content="博客,CyriliS" />
<meta name="description" content="欢迎光临Cyrilis的博客" />
<link rel="stylesheet" type="text/css" href="/style.css" media="all"/>
<link rel="alternate" type="application/rss+xml" title="Cyril IS 博客" href="http://cyrilis.com/rss.php" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33923086-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div id="header">
<div id="logo" style="float:left;">
	<h2><a href="http://cyrilis.com"><img src="/img/logo.png" alt="Cyril IS" style="border:none;"/></a></h2>
</div>
<div id="menu"><a class="bbutton" href="http://lab.cyrilis.com">实验室</a><a class="bbutton" href="http://lrc.cyrilis.com">歌词搜索</a><a class="bbutton" href="http://cyrilis.com/About.html">关于我</a></div>
<div style="clear:both;"></div>
</div> 
<div id='middlea'>
<div id="cyrilis">
<?php 
	require("simple_html_dom.php");
	function get_files($dir) {
		$files = array();
		for (; $dir->valid(); $dir->next()) {
			if ($dir->isDir() && !$dir->isDot()) {
				if ($dir->haschildren()) {
					//$files = array_merge($files, get_files($dir->getChildren()));
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
//单文章页面功能--->
	if(isset($_GET['s']))
	{
		$single=substr($_GET['s'],1);
		if(in_array($single, $indexs))
		{
			$singles=file_get_html("./blog/".$single);
			foreach($singles->find('body') as $e)
			{
			echo "<script type='text/javascript'>document.title ='".$e->find('h1', 0)->innertext."-->Cyril IS 博客'</script><div id='single'>".$e->innertext.'<br></div>'; 
			echo "<script type='text/javascript'>
  //<![data[
    var meta = document.getElementsByTagName('meta');
    for(var i=0;i<meta.length;i++){
      if(meta[i].getAttribute('name')=='description'){
	  meta[i].setAttribute('content','".$e->find('h1', 0)->innertext."');
	  }
    }
  //]]-->
  </script>";
			echo("<div id='disqus_thread'></div><script type='text/javascript'>var disqus_shortname = 'cyrilis';(function() {var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);})();</script><noscript>Please enable JavaScript to view the <a href='http://disqus.com/?ref_noscript'>comments powered by Disqus.</a></noscript><a href='http://disqus.com' class='dsq-brlink'>comments powered by <span class='logo-disqus'>Disqus</span></a>");
			}
		}else{
			echo("<h1>404-----页面无法找到。</h1>");
		}
	}
	//<-----单文章页面结束
	//分页功能--->
	else if(isset($_GET['p']))
	{
		if(is_numeric($_GET['p'])&& $_GET['p']>0 && $_GET['p']<= count($indexs)/10+1){
			$a=0;
			foreach($indexs as $page){
				$a++;
				if($a<=($_GET['p']-1)*10)
				{
					continue;
				}
				else
				{
					$html=file_get_html("./blog/".$page);
					foreach($html->find('body') as $e)
					{
						if(preg_match('/\d+/',$page)){
							$e->find('h1', 0)->innertext ="<a href='".$page."'>".$e->find('h1', 0)->innertext ."</a>";
							echo "<div id='single'>".$e->innertext.'<br>'; 
							echo("<a class='viewc' href='".$page."#disqus_thread'>查看评论->>></a></div>");
							$b=($_GET['p']-1)*10+10;
							if($a==$b)
							{
								break 2;
							}
						}else
						{
						continue;
						}
					}
				}
			}
		echo "<div style='padding:15px;border-top:solid 1px #f9f9f9;height:34px;'>";
		if($_GET['p']>1){echo "<a href='?p=" .($_GET['p']-1)."'><button style='margin-left:10px;'>上一页</button></a>";};
		if($_GET['p']<count($indexs)/10){echo "<a href='?p=" .($_GET['p']+1)."'><button style='float:right;margin-right:20px;'>下一页</button></a>";}
		echo "</div>";
		//echo "<div style='padding:15px;border-top:solid 1px #f9f9f9;'><a href='?p=" .($_GET['p']-1)."'><button style='margin-right:400px;'>上一页</button></a><a href='?p=" .($_GET['p']+1)."'><button>下一页</button></a></div>";
		}
		else{
		echo '参数错误 ！';
		}
	}
	// <----分页功能结束
	//首页----->
	else
	{
		$a=0;
		foreach($indexs as $page){
			$a++;
			$html=file_get_html("./blog/".$page);
			foreach($html->find('body') as $e)
			{
				if(preg_match('/\d+/',$page)){
					$e->find('h1', 0)->innertext ="<a href='".$page."'>".$e->find('h1', 0)->innertext ."</a>";
					echo "<div id='single'>".$e->innertext.'<br>'; 
					echo("<a class='viewc' href='".$page."#disqus_thread'>查看评论->>></a></div>");
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
		if(count($indexs)>10)
		{
			echo "<div style='padding:15px;border-top:solid 1px #f9f9f9;height:34px'><a href='?p=2'><button style='margin-left:500px;'>下一页</button></a></div>";
		}
	}
	//<-----首页结束
 ?> 
</div>
<div id="com">
<div id="recent" style="margin-left:20px;margin-top:30px;">
<div style="margin-left:85px;">最新文章列表</div></br>
	<ol>
		<?php 
		
		$a=0;
		foreach($indexs as $page){
			$a++;
			$html=file_get_html("./blog/".$page);
			foreach($html->find('body') as $e)
			{
				if(preg_match('/\d+/',$page)){
					echo "<li><a style='font-size:18px;' href='".$page."'>".$e->find('h1', 0)->innertext ."</a></li>";
					if($a==5)
					{
						break 2;
					}
				}
				else{
				continue;
				}
			}
		}
		
		?>
	</ol>
</div>
<script src="http://img3.douban.com/js/packed_radiowidget9088440332.js?doubanid=27953152&maxresults=10"></script>

</div></div>
<div id="footer">Copyright © 2012 - Cyr1l - Powered by <a href="https://github.com/cyrilis/pblog">PBlog</a></div>
</body>
</html>