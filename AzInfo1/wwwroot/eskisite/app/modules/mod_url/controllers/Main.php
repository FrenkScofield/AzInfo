<?php 

class Main extends CController
{
	public function actionIndex()
	{
		CUrlHelper::redirect('main');
	}
	
	public function actionSitemap(){
		header('Content-type:text/xml;charset=utf-8');
		echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		?>
		<urlset
		xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
		<?php 
		//$web_url = CUrlHelper::getWebUrl(true);
		$web_url = 'https://www.taximpro.com';
		
		$urls = ModUrlHelper::get_url_list();
		
		foreach($urls as $a){
			?><url>
				<loc><?=$web_url.$a['url']?></loc>
				<?php if(!empty($a['tarih_duzenleme'])){ 
					$ts2 = strtotime($a['tarih_duzenleme']);
					?><lastmod><?= date('c',$ts2) ?></lastmod><?php 					
				} ?>
			</url><?php
		}
		?></urlset><?php	
	}
}
