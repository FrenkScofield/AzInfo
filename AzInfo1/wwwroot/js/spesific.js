/*
//navbar
var h2 = document.getElementById('main');
var h3 = document.getElementById('corporative');
var h4 = document.getElementById('services');
var h5 = document.getElementById('products');
var h6 = document.getElementById('refrances');
var h7 = document.getElementById('communications');

//footer
var footerazinfotur = document.getElementById('footerazinfotur');
var azturp = document.getElementById('azturp');
var footerservice = document.getElementById('footerservice');

var fs1=document.getElementById('fs1');
var fs2=document.getElementById('fs2');
var fs3=document.getElementById('fs3');
var fs4=document.getElementById('fs4');
var fs5=document.getElementById('fs5');
var fs6=document.getElementById('fs6');
var fs7=document.getElementById('fs7');
var fs8=document.getElementById('fs8');



  function detectChange(selectObject) {
    var val = selectObject.value;  
    if(val == "tr"){
      h2.innerHTML = "ANASAYFA";
      h3.innerHTML = "KURUMSAL";
      h4.innerHTML = "HİZMETLER";
      h5.innerHTML = "ÜRÜNLER";
      h6.innerHTML = "REFERANSLAR";
      h7.innerHTML = "İLETİŞİM";

      footerazinfotur.innerHTML = " AZINFO TÜRKİYE";
      azturp.innerHTML = "Altayçeşme Mh. Çamlı Sk. No:16 DAP Royal Center A Blk D.57 Maltepe/İstanbul"
      footerservice.innerHTML = "HIZMETLER"

      fs1.innerHTML = "Su Şartlandırma Hizmeti"
      fs2.innerHTML = "Laboratuvar Hizmetleri"
      fs3.innerHTML = "Legionella Analizleri"
      fs4.innerHTML = "Geri Kazanım"
      fs5.innerHTML = "Sistemlerin Uzaktan Kontrol Edilmesi"
      fs6.innerHTML = "Datalogger İle Verilerin Toplanmas"
      fs7.innerHTML = "Ozonla Bakteri Giderim Sistemleri"
      fs8.innerHTML = "Nötralizasyon Sistemi"

    
    
    }else if(val== "en"){
      h2.innerHTML = "MAIN";
      h3.innerHTML = "CORPORATE";
      h4.innerHTML = "SERVICES";
      h5.innerHTML = "PRODUCTS";
      h6.innerHTML = "REFERANCES";
      h7.innerHTML = "COMMUNUCATION";

      footerazinfotur.innerHTML="AZINFO TURKEY";
      azturp.innerHTML = "Altayçeşme Mh. Çamlı Sk. No:16 DAP Royal Center A Blk D.57 Maltepe/İstanbul"
      footerservice.innerHTML = "Services"

      fs1.innerHTML = "Water Conditioning Service"
      fs2.innerHTML = "Laboratory Services"
      fs3.innerHTML = "Legionella Analyzes"
      fs4.innerHTML = "Regain"
      fs5.innerHTML = "Remote Control of Systems"
      fs6.innerHTML = ""
      fs7.innerHTML = ""
      fs8.innerHTML = ""

    
    
    }else if(val == "ru"){
      h2.innerHTML = "Главная";
      h3.innerHTML = "О нас";
      h4.innerHTML = "Услуги  ";
      h5.innerHTML = "Товары";
      h6.innerHTML = "Ссылки";
      h7.innerHTML = "Контакты";

      footerazinfotur.innerHTML="Azinfo Турция ";
      azturp.innerHTML = "Altayçeşme, Çamlı Sok. No:16 DAP Royal Center A Блок K.13 D.57 34843 Малтепе/Стамбул"
      footerservice.innerHTML = "Услуги "

      fs1.innerHTML = "Услуги по водоподготовке"
      fs2.innerHTML = "Лабораторные услуги"
      fs3.innerHTML = "Анализы легионеллы"
      fs4.innerHTML = "Переработкa"
      fs5.innerHTML = "Удаленное управление системами"
      fs6.innerHTML = "Сбор данных с помощью регистратора данных"
      fs7.innerHTML = ""
      fs8.innerHTML = ""
    
    }
  }

  */
  var arrLang = {
    'tr': {
      'ANASAYFA': 'ANASAYFA',
      'KURUMSAL': 'KURUMSAL',
      'HİZMETLER': 'HİZMETLER',
      'ÜRÜNLER': 'ÜRÜNLER',
      'REFERANSLAR': 'REFERANSLAR',
      'İLETİŞİM': 'İLETİŞİM',

      'sliderwords1': 'Su şartlandırma programlarımızla en uygun koruma kimyasallarını kullanıyor, su sistemlerinizin ömrünü uzatıyoruz.',
      'sliderwords2': 'Geri kazanım projelerimizle yatırımlarınızdan maksimum verim almanızı sağlıyoruz',
       'sliderwords3':'Konusunda uzman su şartlandırma danışmanlarımızla her zaman yanınızdayız',
       
       'year':'YILLIK ',
       'esperinceslider':' SEKTÖREL DENEYİM ',
       'esperinceslider1':'Buhar Üretim Sistem Kimyasalları',
       'esperinceslider2':'Soğutma Kulesi Sistemleri',
       'esperinceslider3':'Kapalı Devre Sistemleri',
       'esperinceslider4':'Dezenfeksiyon Ürünleri',
       'esperinceslider5':'Kullanım Suyu Hatları',
       'esperinceslider6':'Hvac ve Endüstriyel Temizlik Ürünleri',
       'esperinceslider7':'Ters Osmoz (R.O.) Birikinti Önleyici ve Temizlik Ürünleri',
       'esperinceslider8':'Bakteri Uygulamaları',

       'Industrial':'Azinfo Endüstriyel',
       'Institutional':'Kurumsal',
       'Institutionalp1':'Ülkemizin önemli ve prestijli kuruluşlarını portföyünde bulunduran AZINFO, Türkiye’de su şartlandırma danışmanlığı konusundaki otoritesini hizmet kalitesi ile rakipsizleştirmektedir.',
       'Institutionalp2':'AZINFO, iş merkezlerinin, alışveriş merkezlerinin, fabrikaların, hastanelerin,üniversitelerin, otellerin içme-kullanım sularında, ısıtma-soğutma sistemlerinde, buhar kazanlarında, soğutma kulelerinde kullanılan kimyasalları ve kontrol ekipmanlarını sürekli ve kaliteli servis hizmeti ile takip ederek müşterilerimizin pahalı ekipman yatırımlarını koruyup, verimli ömrünün uzun olmasını sağlayarak ekonomiye katkı sağlamayı amaç edinmiştir.',
        'Institutionalp3':'kurumsal',

       'watersystem':'Su Sistemleriniz Özel Su Şartlandırma Programımızla Korunmaktadır',
       'watersystem1':'Firmaların sorunlarına göre ihtiyacı olan çözümler üretilir ve uygulamaya alınır. Bu çözümler ve cihazlarımızdan dozaj tanklarına kadar özenle kurduğumuz su şartlandırma istasyonları ile korumaktadır.',
       'watersystem2':'Saha analiz çantamız ile gittiğimiz her firmada laboratuvar ortamı oluşturup özenle analizler yapıyoruz.',
       'contuning':'Devam Eden',
       'contuning1':'Projeler',
       'contuning2':'Tamamlanan',
        'contuning3':'Projeler',
        'contuning4':'Alınan',
        'contuning5':'Ödüller',
        'contuning6':'Tüm Referanslarımız',

        'footersection1':'AZINFO TÜRKİYE',
        'footeradress1':'Altayçeşme Mh. Çamlı Sk. No:16 DAP Royal Center A Blk D.57 Maltepe/İstanbul',
        'footersection2':'AZINFO AZERBAYCAN',
        'footeradress2':'Yasamal Rayonu Ş.Qurbanov Küçesi No: 21 Blok B Mertebe 5 Menzil 8 Baku/AZERBAIJAN',
        
        'services':'HIZMETLER',
        'services1':'Su Şartlandırma Hizmeti',
        'services2':'Laboratuvar Hizmetleri',
        'services3':'Legionella Analizleri',
        'services4':'Geri Kazanım',
        'services5':'Sistemlerin Uzaktan Kontrol Edilmesi',
        'services6':'Datalogger İle Verilerin Toplanması',
        'services7':'Ozonla Bakteri Giderim Sistemleri',
        'services8':'Nötralizasyon Sistemi',

        'Products':'ÜRÜNLER',
        'Products1':'Buhar Üretim Sistem Kimyasalları',
        'Products2':'Soğutma Kulesi Sistemleri',
        'Products3':'Kapalı Devre Sistemleri',
        'Products4':'Dezenfeksiyon Ürünleri',
        'Products5':'Kullanım Suyu Hatları',
        'Products6':'HVAC ve Endüstriyel Temizlik Ürünleri',
        'Products7':'Ters Osmoz (R.O.)',
        'Products8':'Bakteri Uygulamaları',





    },
    'en': {
      'ANASAYFA': 'MAIN',
      'KURUMSAL': 'CORPORATE',
      'HİZMETLER': 'SERVICES',
      'ÜRÜNLER': 'PRODUCTS',
      'REFERANSLAR': 'COMMUNUCATION',
      'İLETİŞİM': 'CONTACT',

      'sliderwords1': 'With our water treatment programs, we use the most suitable protection chemicals and extend the life of your water systems.',
      'sliderwords2':'We ensure that you get maximum efficiency from your investments with our recycling projects.',
    'sliderwords3':'We are always with you with our expert water treatment consultants.',
    
    'year':'YEARLY ',
    'esperinceslider':' SECTORAL EXPERIENCE',
    'esperinceslider1':'Steam Production System Chemicals',
    'esperinceslider2':'Cooling Tower Systems',
    'esperinceslider3':'Closed Circuit Systems',
    'esperinceslider4':'Disinfection Products',
    'esperinceslider5':'Domestic Water Lines',
    'esperinceslider6':'Hvac and Industrial Cleaning Products',
    'esperinceslider7':'Reverse Osmosis (R.O.) Antifouling and Cleaning Products',
    'esperinceslider8':'Bacteria Applications',

    'Industrial':'Azinfo Industrial',
    'Institutional':'Institutional',
    'Institutionalp1':'Having important and prestigious institutions of our country in its portfolio, AZINFO makes its authority in water treatment consultancy in Turkey unrivaled with its service quality.',
    'Institutionalp2':'AZINFO maintains the expensive equipment investments of our customers by following the chemicals and control equipment used in the drinking-use water, heating-cooling systems, steam boilers, cooling towers of business centers, shopping centers, factories, hospitals, universities, hotels with continuous and high quality service. It aims to contribute to the economy by ensuring its longevity.',
    'Institutionalp3':'corporate',

    'watersystem':'Your Water Systems Are Protected With Our Special Water Treatment Program',
     'watersystem1':'According to the problems of the companies, the solutions they need are produced and put into practice. It is protected by these solutions and water conditioning stations that we carefully set up from our devices to dosage tanks.',
     'watersystem2':'With our field analysis bag, we create a laboratory environment in every company we go to and make careful analyzes.',
      'contuning':'Continuing',
      'contuning1':'Projects',
      'contuning2':'Completed',
      'contuning3':'Projects',
      'contuning4':'Awards',
      'contuning5':'Recieved',
      'contuning6':'All Our References',
      
      'footersection1':'AZINFO TURKEY',
      'footeradress1':'Altayçeşme Mh. Çamlı Sk. No:16 DAP Royal Center A Blk D.57 Maltepe/İstanbul',
        'footersection2':'AZINFO AZERBAIJAN',
        'footeradress2':'Yasamal Rayonu Ş.Qurbanov Küçesi No: 21 Blok B Mertebe 5 Menzil 8 Baku/AZERBAIJAN',

        'services':'SERVICES',
        'services1':'Water Conditioning Service',
        'services2':'Laboratory Services',
        'services3':'Legionella Analyzes',
        'services4':'Regain',
        'services5':'Remote Control of Systems',
        'services6':'Data Collection with Datalogger',
        'services7':'Bacteria Removal Systems with Ozone',
        'services8':'Neutralization System',

        'Products':'PRODUCTS',
        'Products1':'Steam Production System Chemicals',
        'Products2':'Cooling Tower Systems',
        'Products3':'Closed Circuit Systems',
        'Products4':'Disinfection Products',
        'Products5':'Domestic Water Lines',
        'Products6':'HVAC and Industrial Cleaning Products',
        'Products7':'Reverse Osmosis (R.O.)',
        'Products8':'Bacteria Applications',

    
    
    
    
    },
    'ru': {
      'ANASAYFA': 'Главная',
      'KURUMSAL': 'О нас',
      'HİZMETLER': 'Услуги',
      'ÜRÜNLER': 'Товары',
      'REFERANSLAR': 'Сылки',
      'İLETİŞİM': 'Контакты',

      'sliderwords1': 'В наших программах очистки воды мы используем наиболее подходящие химические вещества для защиты и продлеваем срок службы ваших систем водоснабжения.',
      'sliderwords2':'Mы гарантируем, что вы получите максимальную эффективность от своих инвестиций с помощью наших проектов по переработке',
    'sliderwords3':'Mы всегда рядом с вами с нашими опытными консультантами по водоподготовке ',
    
    'year':'ЕЖЕГОДНО ',
    'esperinceslider':' ОТРАСЛЕВОЙ ОПЫТ',
    'esperinceslider1':'Парогенераторы для химических производств',
    'esperinceslider2':'Системы охлаждения',
    'esperinceslider3':'3амкнутые системы',
    'esperinceslider4':'Средства дезинфекции',
    'esperinceslider5':'Питьевая вода',
    'esperinceslider6':'HVAC и промышленные чистящие средства',
    'esperinceslider7':'Обратный осмос (RO) Противообрастающие и чистящие средства',
    'esperinceslider8':'Бактериальные аппликации',

    'Industrial':'Azinfo Промышленность',
    'Institutional':'Институциональный',
    'Institutionalp1':'Владея портфолио  важных и престижных учреждений нашей страны, мы проводим  консультации по вопросам качества воды и услуг по очистке воды в Турции.',
    'Institutionalp2':'AZINFO постоянно контролирует химические вещества и контрольное оборудование, используемое в питьевой воде в бизнес-центрах, торговых центрах, фабриках, больницах, университетах, гостиницах, системах отопления и охлаждения, паровых котлах, градирнях, с непрерывным и высококачественным обслуживанием, защищая вложения наших клиентов в дорогостоящее оборудование, и он нацелен на вклад в экономику, обеспечивая его долговечность.',
    'Institutionalp3':'О нас',

     'watersystem':'Ваши водные системы защищены нашей специальной программой по водоподготовке',
      'watersystem1':'Решения, которые нужны компаниям в соответствии с их проблемами, производятся и внедряются. Он защищает с помощью этих растворов и станций водоподготовки, которые мы тщательно настраиваем, от наших устройств до дозирующих резервуаров.',
      'watersystem2':'С помощью сумки  для анализа воды  мы создаем лабораторную среду в каждой компании, в которую мы работаем, и тщательно анализируем ее.',
      'contuning':'Продолжающие',
      'contuning1':'Проекты',
      'contuning2':'3авершенный',
      'contuning3':'Проекты',
      'contuning4':'Полученные',
      'contuning5':'Награды',
      'contuning6':'Все наши рекомендации',
      
      'footersection1':'Azinfo Турция',
        'footeradress1':'Altayçeşme, Çamlı Sok. No:16 DAP Royal Center A Блок K.13 D.57 34843 Малтепе/Стамбул',
       'footersection2':'AZINFO Aзербайджан',
      'footeradress2':'Ясамал Району Ш.Гурбанов Кючеси № 21 Блок Б Мертебе 5 Мензил 8 Баку/АЗЕРБАЙДЖАН',
      
      

      'Products':'Товары',
      'Products1':'Химические системы парагенераторов',
      'Products2':'системы охлаждения',
      'Products3':'Замкнутые системы',
      'Products4':'Средства дезинфекции',
      'Products5':'Использование питьевых водопроводов',
      'Products6':'HVAC и промышленные чистящие средства',
      'Products7':'Обратный осмос',
      'Products8':'Применение бактерий',


    
    }
    
  };

  $('.translate').click(function() {
    var lang = $(this).attr('id');
   //on click store language on click to localStorage
  localStorage.setItem("stored_lang",lang);
  translateLang(lang);
    });

  function translateLang(lang)
	{
		$('.lang').each(function(index, item) {
          $(this).text(arrLang[lang][$(this).attr('key')]);
        });
	}
	
    $(function() {
		//first check for stored language in localStorage i.e. fetch data from localStorage
		let stored_lang = localStorage.getItem("stored_lang");
		//if any then translate page accordingly
		if(stored_lang != null && stored_lang != undefined)
		{
			lang = stored_lang;
			translateLang(lang);
		}
    });
