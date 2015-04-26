echo "Updating database..."

echo "Making a backup..."
cd /Extra/EDP/bin
rm -Rf /Extra/EDP/bin/backup/edp.sqlite3
cp edp.sqlite3 /Extra/EDP/bin/backup

echo "Cleaning up database..."
rm -Rf edp.sqlite3

echo "Downloading new database..."
if curl -o edp.sqlite3 http://www.osxlatitude.com/dbupdate.php --connect-timeout 10 ; then
    echo "Database successfully downloaded"
else
    echo "Could not update database... using backup"
    cp backup/edp.sqlite3 ./edp.sqlite3
fi

echo "<br>Database Update finished."

echo "<br>Cleaning up EDP svn..."
svn cleanup /Extra/EDP/bin
svn cleanup /Extra/EDP/phpWebServer

echo "Downloading latest sources from EDP's svn server..."
echo "Updating EDP files..."
if svn --non-interactive --username edp --password edp --force update /Extra/EDP/bin; then
	echo "Updating PHP binary..."
	if svn --non-interactive --username edp --password edp --force update /Extra/EDP/phpWebServer; then
		cd /Extra/EDP/phpWebServer
		rm -rf /Extra/EDP/php
		unzip -X -qq php.zip -d /Extra/EDP
		touch /Extra/EDP/logs/update/Updsuccess.txt
		echo "Update success"
	else
		touch /Extra/EDP/logs/update/Updfail.txt
		echo "Update failed (may be no internet or failed to connect to svn)"
	fi
else
	touch /Extra/EDP/logs/update/Updfail.txt
	echo "Update failed (may be no internet or failed to connect to svn)"
fi

chmod -R 755 /Extra/EDP/bin
chmod -R 755 /Extra/EDP/phpWebServer

echo "<br>EDP Updates finished."
