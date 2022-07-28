cp ./.sample_init.php ../init.php
cp ./.sample_session.php ../session.php
cp ./.sample_index.php ../index.php
cp ./.sample_image.php ../image.php
cp ./.sample_captcha.php ../captcha.php
cp ./.sample_htaccess ../.htaccess
cp ./.sample_robots.txt ../robots.txt
mkdir ../app/
cp ./_sample_app_folder_/* ../app/ -R
mv ../app/_.htaccess ../app/.htaccess
mkdir ../media/
cp ./_sample_media_folder_/* ../media/ -R
mkdir ../app/admin/
git clone https://webcoder@bitbucket.org/webcoder/mod_admin.git ../app/modules/mod_admin/
chmod go-w -R ../*
chmod a-x+X -R ../*
chmod 777 ../media
chmod 777 ../media/cache
chmod 777 ../media/images
chmod 777 ../media/files
chmod 777 ../app/tmp -R
chmod 644 ../app/tmp/cache/.htaccess
chmod a+x ../index.php
