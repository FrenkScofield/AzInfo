<?php

class Main extends CController {

	public function _beforeAction($action = null) {
		
		$this->template = 'genel';
		
		$actions = array(
			'actionKurumsal'=>array(
				'baslik'=>_l('HAKKIMIZDA'),				
				'bc'=>array(
					'title'=>_l('Hakkımızda'),
					'href'=>''
				),				
			),
			'actionHizmetler'=>array(
				'baslik'=>_l('HİZMETLERİMİZ'),				
				'bc'=>array(
					'title'=>_l('Hizmetlerimiz'),
					'href'=>''
				),				
			),
			'actionReferanslar'=>array(
				'baslik'=>_l('REFERANSLARIMIZ'),				
				'bc'=>array(
					'title'=>_l('Referanslarımız'),
					'href'=>''
				),				
			),
			'actionHaberler'=>array(
				'baslik'=>_l('HABERLER'),				
				'bc'=>array(
					'title'=>_l('Haberler'),
					'href'=>''
				),				
			),
			'actionIletisim'=>array(
				'baslik'=>_l('İLETİŞİM'),				
				'bc'=>array(
					'title'=>_l('İletişim'),
					'href'=>''
				),				
			),
			'actionSeminerler'=>array(
				'baslik'=>_l('EĞİTİM SEMİNERLERİ'),				
				'bc'=>array(
					'title'=>_l('Eğitim Seminerleri'),
					'href'=>''
				),				
			),
			'actionInsan_kaynaklari'=>array(
				'baslik'=>_l('İNSAN KAYNAKLARI'),
				'bc'=>array(
					'title'=>_l('İnsan Kaynakları'),
					'href'=>''
				),				
			),
			'actionUrunler'=>array(
				'baslik'=>_l('ÜRÜNLERİMİZ'),
				'bc'=>array(
					'title'=>_l('Ürünlerimiz'),
					'href'=>CUrlHelper::getUrl('main/urunler')
				),				
			),
			'actionNsf_urunler'=>array(
				'baslik'=>_l("NSF'Lİ ÜRÜNLERİMİZ"),
				'bc'=>array(
					'title'=>_l("NSF'li Ürünlerimiz"),
					'href'=>CUrlHelper::getUrl('main/nsf_urunler')
				),				
			),
			'actionOzon_sistemleri'=>array(
				'baslik'=>_l('OZON SİSTEMLERİ'),
				'bc'=>array(
					'title'=>_l('Ozon Sistemleri'),
					'href'=>CUrlHelper::getUrl('main/ozon_sistemleri')
				),				
			),
		);
		
		if(isset($actions[$action])){
			$a = & $actions[$action];
			$this->addTitle($a['baslik']);
			_setAppData('ustbaslik', $a['baslik']);
			$this->addBc($a['bc']);		
		}
		
	}

	public function actionIndex() {
		$this->template = false;
		$this->render('anasayfa');
	}

	public function actionKurumsal() {
		
		AppHelper::bolum_ayarlari('kurumsal');
		
		$model = new KurumsalModel();
		$model->find() || CCoreHelper::show404();
		
		$data = array(
			'baslik'=>$model->baslik,
			'yazi'=>$model->yazi,
			'resim'=> CImageHelper::get($model->resim),
		);
		
		$this->render('kurumsal',$data);
	}

	public function actionHizmetler() {
		AppHelper::bolum_ayarlari('hizmetler');
		
		
		$data = array(
			'rows'=>array()
		);
		
		$model = new HizmetModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){			
			$hizmet_id = $model->getId();
			$resim = CImageHelper::get($model->resim);
			$data['rows'][$hizmet_id] = array(
				'baslik'=>$model->baslik,
				'aciklama'=>$model->aciklama,
				'resim'=> $resim,
				//'resimler'=> CImageHelper::getAll($model->resimler) // resimler alt tablodan alınacak
				'galeri'=>array()
			);
		}
		
		$model = new Hizmet_galeriModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$hizmet_id = $model->hizmet_id;
			if(!isset($data['rows'][$hizmet_id])){
				continue;
			}
			$resim = CImageHelper::get($model->resim);
			if(empty($resim)){
				continue;
			}
			
			$data['rows'][$hizmet_id]['galeri'][] = array(
				'resim'=> $resim,
				'link'=>$model->link
			);
		}
		
		$this->render('hizmetler',$data);
	}
	/*
	public function actionHizmetler_yama(){
		
		$insert = array(); // hizmet_galeri tablosuna eklenecek kayıtlar
		
		$model = new HizmetModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$hizmet_id = $model->getId();
			$resimler = CImageHelper::getAll($model->resimler);
			
			if(count($resimler)){
				foreach($resimler as $i=>$r){
					$insert[] = array(
						'hizmet_id'=>$hizmet_id,
						'sira'=>($i+1),
						'resim'=>$r						
					);
				}
			}			
		}
		// galeri kayıtlarını ekle
		$model = new Hizmet_galeriModel();
		foreach($insert as $row){
			$model->insert($row);
		}
		echo '--ok--';
	}
	*/

	private function belgeler($bolum) {		
		AppHelper::bolum_ayarlari($bolum);
		
		switch($bolum){
			case 'belgeler':
				$this->addBc(array(
					'title'=>_l('Ürünler'),
					'href'=>'javascript:void();'
				));
				$this->addBc(array(
					'title'=>_l('Belgeler'),
					'href'=>''
				));
				$this->addTitle(_l('Belgeler'));
				_setAppData('ustbaslik', _l('BELGELER'));
				break;
			
			case 'teknik_belgeler':
				$this->addBc(array(
					'title'=>_l('Sertifikalar'),
					'href'=>'javascript:void();'
				));
				$this->addBc(array(
					'title'=>_l('Teknik Belgeler'),
					'href'=>''
				));
				$this->addTitle(_l('Teknik Belgeler'));
				_setAppData('ustbaslik', _l('TEKNİK BELGELER'));
				break;
			
			case 'kalite_belgeleri':
				$this->addBc(array(
					'title'=>_l('Sertifikalar'),
					'href'=>'javascript:void();'
				));
				$this->addBc(array(
					'title'=>_l('Kalite Belgeleri'),
					'href'=>''
				));
				$this->addTitle(_l('Kalite Belgeleri'));
				_setAppData('ustbaslik', _l('KALİTE BELGELERİ'));
				break;
			
			case 'sistem_bilgi_formatlari':
				$this->addBc(array(
					'title'=>_l('Sertifikalar'),
					'href'=>'javascript:void();'
				));
				$this->addBc(array(
					'title'=>_l('Sistem Bilgi Formatları'),
					'href'=>''
				));
				$this->addTitle(_l('Sistem Bilgi Formatları'));
				_setAppData('ustbaslik', _l('SİSTEM BİLGİ FORMATLARI'));
				break;
		}
		
		
		$data = array(
			'rows'=>array()
		);
		$model = new BelgeModel();
		$model->where(array('bolum'=>$bolum,'dil'=>LANG))->orderBy('`sira`')->run();
		while($model->fetchRow()){
			$data['rows'][] = array(
				'baslik'=>$model->baslik,
				'dosya'=> CFileHelper::getFirst($model->dosya),
                'resim'=> CImageHelper::get($model->resim),
			);
		}
		
		$this->render('belgeler',$data);
	}
	
	public function actionBelgeler(){
		$this->belgeler('belgeler');
	}
	public function actionTeknik_belgeler(){
		$this->belgeler('teknik_belgeler');
	}
	public function actionKalite_belgeleri(){
		$this->belgeler('kalite_belgeleri');
	}
	public function actionSistem_bilgi_formatlari(){
		$this->belgeler('sistem_bilgi_formatlari');
	}
	

	public function actionReferanslar() {		
		AppHelper::bolum_ayarlari('referanslar');
		
		$data = array(
			'tumu'=>array(),
			'sekmeler'=>array()
		);
		
		$model = new ReferansModel();
		$model->with('Kategori')->orderBy('`Kategori`.`sira` ASC, `referans`.`sira` ASC')->run();
		while($model->fetchRow()){
			$logo = CImageHelper::get($model->logo);					
			
			if(empty($logo)){
				continue;
			}
			
			$add = array(
				'logo'=>$logo,
				'baslik'=>$model->baslik,
				'aciklama'=>$model->aciklama,
				'videolar'=> HtmlHelper::lines($model->videolar), // adminde tek alana dönüştürüldü
				'mektup'=> CFileHelper::getFirst($model->mektup)
			);
			
			$cat = $model->Kategori->baslik;
			if(!isset($data['sekmeler'][$cat])){
				$data['sekmeler'][$cat] = array();
			}
			
			$data['sekmeler'][$cat][] = $add;			
			$data['tumu'][] = $add;
		}
		
		$this->render('referanslar',$data);
	}
	
	public function actionHaberler() {		
		AppHelper::bolum_ayarlari('haberler');
		
		$data = array(
			'rows'=>array()
		);
		
		$model = new HaberModel();
		$model->orderBy('`tarih` DESC, `haber_id` DESC ')->run();
		while($model->fetchRow()){
			$data['rows'][] = array(
				'baslik'=>$model->baslik,
				'tarih'=>$model->tarih,
				'aciklama'=>$model->aciklama,
				'resimler'=> CImageHelper::getAll($model->resimler)
			);
		}
		
		$this->render('haberler',$data);
	}
	
	public function actionIletisim() {
		AppHelper::bolum_ayarlari('iletisim');
		
		$data = array(
			'adresler' => array()
		);
		
		$model = new Iletisim_adresModel();
		$model->orderBy('`sira` ASC')->run();
		while ($model->fetchRow()) {
			$data['adresler'][] = array(
				'id' => $model->getId(),
				'baslik'=>$model->baslik,
				'adres' => $model->adres,
				'telefon' => $model->telefon,
				'faks' => $model->faks,
				'email' => $model->email,
				'enlem' => $model->enlem,
				'boylam' => $model->boylam,
				'harita_link'=>$model->harita_link,
			);
		}
		
		$this->render('iletisim',$data);
	}
	
	public function actionSeminerler() {
		AppHelper::bolum_ayarlari('seminerler');
		
		$data = array(
			'yazi'=>'',
			'rows'=>array()
		);
		
		$model = new SeminerlerModel();
		if($model->find()){
			$data['yazi'] = $model->yazi;
		}
		
		$model = new SeminerModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$data['rows'][] = array(
				'baslik'=>$model->baslik,
				'resimler'=>CImageHelper::getAll($model->resimler)
			);
		}
		
		$this->render('seminerler',$data);
	}
	
	
	public function actionInsan_kaynaklari() {
		AppHelper::bolum_ayarlari('ik');
		
		$data = array(
			'form' => new IkForm(),
			'result' => false,
			'yazi'=>''
		);
		
		$model = new IkModel();
		if($model->find()){
			$data['yazi'] = $model->yazi;
		}

		$form = & $data['form'];

		if ($form->run(true)) {
			$to = ModSiteHelper::get_emails('form2_alicilar');

			//unset($form->_fields['kepce']); // emailde gerek yok
			
			// Ek dosya varsa ekle
			$ek_dosya = null;

			$upload_path = APP_PATH . '/tmp/';

			$file = CUploadHelper::uploadFile(array(
				'input_name' => 'file',
				'file_path' => $upload_path,
				'keep_original_name' => true,
			));

			if ($file != false) {
				$ek_dosya = $upload_path . $file;
			}

			if (!($result = EmailHelper::send($to, 'İK Başvuru Formu', $form->toHtml(), $form->email, $ek_dosya))) {
				$form->addError('Form gönderimi sırasında hata oluştu. Lütfen tekrar deneyiniz.');
			} else {
				$data['result'] = true;
				$form->addError(_l('Form gönderilmiştir!'));
			}

			// dosya yüklenmişse sunucudan kaldır
			if (is_file($ek_dosya)) {
				unlink($ek_dosya);
			}
		}


		$this->render('insan_kaynaklari',$data);
	}
	
	public function actionUrunler(){
		
		AppHelper::bolum_ayarlari('urunler');
		
		if(($cid=CCoreHelper::getIdParam('cid'))){ // kategorideki ürünleri listele
			
			$data = array(
				'rows'=>array(),
				'kategori_baslik'=>'',
				'kategori_simge'=>''
			);
			
			$model = new UrunModel();
			$model->where(array('kategori_id'=>$cid))->orderBy('`sira` ASC')->run();
			while($model->fetchRow()){
				if(empty($data['kategori_baslik'])){
					$data['kategori_baslik'] = $model->Kategori->baslik;
					$data['kategori_simge'] = CImageHelper::get($model->Kategori->simge);
					
					$this->addTitle($model->Kategori->baslik);
					$this->addBc(array(
						'title'=>$model->Kategori->baslik,
						'href'=>''
					));
				}
				
				$data['rows'][] = array(
					'baslik'=>$model->baslik,
					'aciklama'=>$model->aciklama,
					'resimler'=>CImageHelper::getAll($model->resimler)
				);
			}
			
			$this->render('urunlerimiz_detay',$data);
		}
		else { // kategorileri listele
			$data = array(
				'rows'=>array()
			);
			
			$model = new Urun_kategoriModel();
			$model->orderBy('`sira` ASC')->run();
			while($model->fetchRow()){
				$data['rows'][] = array(
					'baslik'=>$model->baslik,
					'simge'=> CImageHelper::get($model->simge),
					'simge2'=> CImageHelper::get($model->simge2),
					'url'=>CUrlHelper::getUrl('main/urunler',array('cid'=>$model->getId()),$model->baslik)
				);
			}
			
			$this->render('urunler',$data);
		}
	}
	
	public function actionNsf_urunler() {
		AppHelper::bolum_ayarlari('nsf_urunler');
		
		$data = array();
				
		$model = new NsfModel();
		$model->orderBy('`sira` ASC')->run();
		while($model->fetchRow()){
			$dosya = CFileHelper::getFirstValid($model->dosya);
			$link = !empty($dosya)? FILES_URL.'/'.$dosya : 'javascript:void();';
			$data['rows'][] = array(
				'isim'=>$model->isim,
                'resim'=> CImageHelper::get($model->resim),
				'link'=>$link				
			);
		}
		
		$this->render('nsf_urunler',$data);
	}
	
	public function actionOzon_sistemleri(){
		AppHelper::bolum_ayarlari('ozon_sistemleri');
		
		if(($id=CCoreHelper::getIdParam('id'))){
			
			$model = new OzonModel();
			$model->findByPk($id) || CCoreHelper::show404();
			
			$data = array(
				'baslik'=>$model->baslik,
				'aciklama'=>$model->aciklama,
				'resim'=> CImageHelper::get($model->resim),
				'kutu1'=>$model->kutu1,
				'kutu2'=>$model->kutu2,
				'kutu3'=>$model->kutu3,
				'link'=>$model->link,
			);
			
			$this->addTitle($model->baslik);
			$this->addBc(array(
				'title'=>$model->baslik,
				'href'=>'',
			));
			
			$this->render('ozon_sistemleri_detay',$data);
		}
		else {
			$data = array(
				'rows'=>array()
			);
			
			$model = new OzonModel();
			$model->orderBy('`sira` ASC')->run();
			while($model->fetchRow()){
				$data['rows'][] = array(
					'baslik'=>$model->baslik,
					'simge'=> CImageHelper::get($model->simge),
					'simge2'=> CImageHelper::get($model->simge2),
					'url'=> CUrlHelper::getUrl('main/ozon_sistemleri',array('id'=>$model->getId()),$model->baslik)
				);
			}
			
			$this->render('ozon_sistemleri',$data);
		}
	}
	
	

}
