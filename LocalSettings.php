<?php
# This file was automatically generated by the MediaWiki 1.26.2
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

if (strstr($_SERVER['SERVER_NAME'], 'dev') || strstr($_SERVER['SERVER_NAME'], 'localhost')) {
    require_once("$IP/config/dev.php");
} else {
    require_once("$IP/config/prod.php");
}


## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = $config['siteName'];

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = $config['ScriptPath'];

## The protocol and server name to use in fully-qualified URLs
$wgServer = $config['siteUrl'];


## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/logoNodos.png";

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEmergencyContact = "apache@plataformanodos.org";
$wgPasswordSender = "apache@plataformanodos.org";

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = false;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = $config['dbName'];
$wgDBuser = $config['dbUser'];
$wgDBpassword = $config['dbPass'];

# MySQL specific settings
$wgDBprefix = "";

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=utf8";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = array();

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
#$wgUseImageMagick = true;
#$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "en_US.utf8";

## If you want to use image uploads under safe mode,
## create the directories images/archive, images/thumb and
## images/temp, and make them all writable. Then uncomment
## this, if it's not already uncommented:
#$wgHashedUploadDirectory = false;

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
#$wgCacheDirectory = "$IP/cache";

# Site language code, should be one of the list in ./languages/Names.php
$wgLanguageCode = "es";

$wgSecretKey = "6b5b77d5f861961c73e7b90246639bc55893ef7898256eb35a8e85aeba315699";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "4878167608c816c9";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = "Adherí al Pacto"; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl = "http://creativecommons.org/licenses/by-sa/4.0/";
$wgRightsText = "Creative Commons Atribución-Compartir Igual. Con algunos detalles";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/usr/bin/diff3";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "Nodos";

# Enabled skins.
wfLoadSkin( 'Nodos' );

#email notifications
$wgSMTP = array(
    'host'     => $config['emailHost'],
    'IDHost'   => $config['emailIDHost'],
    'port'     => $config['emailPort'],
    'username' => $config['emailUser'],
    'password' => $config['emailPass'],
    'auth'     => $config['emailAuth']
);

# End of automatically generated settings.
# Add more configuration options below.

require_once "$IP/extensions/SemanticMediaWiki/SemanticMediaWiki.php";
enableSemantics( 'plataformanodos.org' );

require_once "$IP/extensions/PageForms/PageForms.php";

require_once("$IP/extensions/SemanticExtraSpecialProperties/SemanticExtraSpecialProperties.php");
require_once("$IP/extensions/SemanticInternalObjects/SemanticInternalObjects.php");

wfLoadExtension( 'ParserFunctions' );


// s3 filesystem repo
$wgUploadDirectory = 'images';
$wgUploadS3Bucket = $config['s3bucket'];
$wgUploadS3SSL = false; // true if SSL should be used
$wgPublicS3 = true; // true if public, false if authentication should be used

$wgS3BaseUrl = "http".($wgUploadS3SSL?"s":"")."://s3.amazonaws.com/$wgUploadS3Bucket";

//viewing needs a different url from uploading. Uploading doesnt work on the below url and viewing doesnt work on the above one.
$wgS3BaseUrlView = "http".($wgUploadS3SSL?"s":"")."://".$wgUploadS3Bucket.".s3.amazonaws.com";
$wgUploadBaseUrl = "$wgS3BaseUrlView/$wgUploadDirectory";

// leave $wgCloudFrontUrl blank to not render images from CloudFront
$wgCloudFrontUrl = '';//"http".($wgUploadS3SSL?"s":"").'://YOUR_CLOUDFRONT_SUBDOMAIN.cloudfront.net/';
$wgLocalFileRepo = array(
    'class' => 'LocalS3Repo',
    'name' => 's3',
    'directory' => $wgUploadDirectory,
    'url' => $wgUploadBaseUrl ? $wgUploadBaseUrl . $wgUploadPath : $wgUploadPath,
    'urlbase' => $wgS3BaseUrl ? $wgS3BaseUrl : "",
    'hashLevels' => $wgHashedUploadDirectory ? 2 : 0,
    'thumbScriptUrl' => $wgThumbnailScriptPath,
    'transformVia404' => !$wgGenerateThumbnailOnParse,
    'initialCapital' => $wgCapitalLinks,
    'deletedDir' => $wgUploadDirectory.'/deleted',
    'AWS_ACCESS_KEY' => $config['s3AccessKey'],
    'AWS_SECRET_KEY' => $config['s3SecretKey'],
    'AWS_S3_BUCKET' => $wgUploadS3Bucket,
    'AWS_S3_PUBLIC' => $wgPublicS3,
    'AWS_S3_SSL' => $wgUploadS3SSL,
    'cloudFrontUrl' => $wgCloudFrontUrl,
);
require_once("$IP/extensions/LocalS3Repo/LocalS3Repo.php");

$wgGroupPermissions['*']['createaccount'] = $config['createAccount'] || false;
$wgGroupPermissions['*']['viewedittab'] = false;
$wgGroupPermissions['*']['edit'] = false;
$wgGroupPermissions['*']['read'] = true;
$wgGroupPermissions['user']['viewedittab'] = false;
$wgGroupPermissions['user']['createpage'] = false;
$wgGroupPermissions['sysop']['viewedittab'] = true;

//renames the "Edit with form" tab to "edit", and the "edit" tab to "edit source"
$wgPageFormsRenameEditTabs = true;

//Calendar global configuration
$wgPageFormsDatePickerSettings['DateFormat'] = 'dd/mm/yy';
$wgPageFormsDatePickerSettings['WeekStart'] = '1';
$wgPageFormsDatePickerSettings['DisableInputField'] = false;

$wgPageFormsLinkAllRedLinksToForms = true;


wfLoadExtension( 'EmbedVideo' );


//Sign up

$wgEmailAuthentication = true;
$wgEmailConfirmToEdit = true;

wfLoadExtensions( array( 'ConfirmEdit', 'ConfirmEdit/ReCaptchaNoCaptcha' ) );
$wgCaptchaClass = 'ReCaptchaNoCaptcha';
$wgReCaptchaSiteKey = $config['captchaPublicKey'];
$wgReCaptchaSecretKey = $config['captchaPrivateKey'];

$wgGroupPermissions['*']['skipcaptcha']             = false;
$wgGroupPermissions['user']['skipcaptcha']          = false;
$wgGroupPermissions['autoconfirmed']['skipcaptcha'] = false;
$wgGroupPermissions['bot']['skipcaptcha']           = true; // registered bots
$wgGroupPermissions['sysop']['skipcaptcha']         = true;

$wgCaptchaTriggers['edit']                          = false;
$wgCaptchaTriggers['create']                        = false;
$wgCaptchaTriggers['addurl']                        = true;
$wgCaptchaTriggers['createaccount']                 = true;
$wgCaptchaTriggers['badlogin']                      = true;

//deshabilitar captcha para usuarios que confirmaron
$wgGroupPermissions['emailconfirmed']['skipcaptcha'] = true;
$ceAllowConfirmedEmail = true;


$wgLocaltimezone = 'America/Argentina/Buenos_Aires';
$wgExternalLinkTarget = '_blank';
$wgFooterIcons = array(
    "custom" => array(
        "gec" => array(
            "src" => "$wgResourceBasePath/resources/assets/footer/gecLogoTransparente.png",
            "alt" => "Grupo de Estudio sobre el Cuerpo",
            "height" => 50,
            "width" => "",
            "url" => "http://grupodeestudiosobrecuerpo.blogspot.com.ar/"
        ),
        "cientopolis" => array(
            "src" => "$wgResourceBasePath/resources/assets/footer/cientopolis.png",
            "alt" => "Cientópolis",
            "height" => 50,
            "url" => "https://www.cientopolis.org/",
            "width" => ""
        ),
        "lifia" => array(
            "src" => "$wgResourceBasePath/resources/assets/footer/lifia.png",
            "alt" => "Lifia",
            "height" => 50,
            "width" => "",
            "url" => "http://www.lifia.info.unlp.edu.ar/"
        ),
        "unlpinfo" => array(
            "src" => "$wgResourceBasePath/resources/assets/footer/logo-inforamtica-unlp.png",
            "alt" => "Facultad de Informática - Universidad Nacional de La Plata",
            "height" => 50,
            "width" => "",
            "url" => "http://info.unlp.edu.ar/"
        ),
        /*"unlp" => array(
            "src" => "$wgResourceBasePath/resources/assets/footer/unlpbackgroundless.png",
            "alt" => "Universidad Nacional de La Plata",
            "height" => 50,
            "width" => "",
            "url" => "http://www.unlp.edu.ar/"
        ),*/
    ),
    "poweredby" => array(
        "mediawiki" => array(
            "src" => null, // Defaults to "$wgStylePath/common/images/poweredby_mediawiki_88x31.png"
            "url" => "https://www.mediawiki.org/",
            "alt" => "Powered by MediaWiki"
            ),
        "semanticmediawiki" => array(
            'src' =>  $wgResourceBasePath . '/extensions/SemanticMediaWiki/res/images/smw_button.png',
            'url' => 'https://www.semantic-mediawiki.org/wiki/Semantic_MediaWiki',
            'alt' => 'Powered by Semantic MediaWiki'
        )
    ),
    "copyright" => array(
        "copyright" => array(
            'src' =>  "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png",
            'url' => 'http://creativecommons.org/licenses/by-sa/4.0/',
            'alt' => 'Creative Commons'
        )
    )
);
