<?php

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'nodos' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['nodos'] = __DIR__ . '/i18n';
	$wgExtensionMessagesFiles['nodosAlias'] = __DIR__ . '/nodos.i18n.alias.php';
	$wgExtensionMessagesFiles['nodosMagic'] = __DIR__ . '/nodos.i18n.magic.php';
	wfWarn(
		'Deprecated PHP entry point used for nodos extension. Please use wfLoadExtension ' .
		'instead, see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return true;
} else {
	die( 'This version of the nodos extension requires MediaWiki 1.25+' );
}
