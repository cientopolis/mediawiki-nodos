#!/bin/sh

echo "Para que la wiki se ponga en modo de solo lectura mientras se realiza el backup se debe usar el parametro -ro"

#Para que el script funcione se deben configurar estos directorios
#Ubicacion del LocalSettings.php
configfile="LocalSettings.php"
#Ubicacion de los archivos de la wiki
wikidirectory=""
#Directorio donde se va a realizar el backup
bkdir="backup"
#Archivo con datos la la DB
dbdatafile="prod.php"

DATE=`date +%Y.%m.%d-%H.%M.%S`
YEAR=`date +%Y`
agregado=false
read_only=false


#Datos requeridos por mysqldump
userid=`grep -i "dbuser" $dbdatafile|cut -d "'" -f4`
dbname=`grep -i "dbname" $dbdatafile|cut -d "'" -f4`
dbpass=`grep -i "dbpass" $dbdatafile|cut -d "'" -f4`

echo "Backup de las paginas..."
#Backup de las paginas de la wiki
php $wikidirectory/maintenance/dumpBackup.php --full > $bkdir/xmldump."$DATE".xml
s3cmd put $bkdir/xmldump."$DATE".xml s3://nodos/backup/"$YEAR"/xmldump."$DATE".xml
rm $bkdir/xmldump."$DATE".xml
echo "listo"

echo "Backup de la base de datos..."
#Se hace el dump se comprime y se se sube a s3
#Es nescesario que se hay configurado s3 con s3cmd --configure
mysqldump --opt --user=$userid --password=$dbpass $dbname > $bkdir/db."$DATE".sql
tar czf $bkdir/db."$DATE".sql.tar $bkdir/db."$DATE".sql
rm $bkdir/db."$DATE".sql
s3cmd put $bkdir/db."$DATE".sql.tar s3://nodos/backup/"$YEAR"/db."$DATE".sql.tar
rm $bkdir/db."$DATE".sql.tar
echo "Listo"

#chekeamos que se haya agregado la linea
if [ $agregado = true ]; then
	#Se borra la linea que se agrego y la wiki deja de estar en modo solo lectura
	sed -i '$d' $configfile
	echo "Modo solo lectura desactivado"
fi