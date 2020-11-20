<?php
// Réinintialisation des fichiers de démo :

function ReplaceFiles ($dirBase, $dirCopy) {

// Suppression de tous les fichiers du répertoire $dirCopy :

	if ($handle = opendir($dirCopy)) {
		while (false !== ($entry = readdir($handle))) {
			$filenameOld = $dirCopy . $entry;
			if(is_file($filenameOld)) {
				if(unlink($filenameOld)) {
//					echo($filenameOld . ' bien supprimé.<br>');
				}
			}
		}
		closedir($handle);
	}
//echo ('<br>');
// Copie des fichiers du répertoire $dirBase vers le répertoire $dirCopy :

	if ($handleBase = opendir($dirBase)) {

		while (false !== ($entryBase = readdir($handleBase))) {
			$filenameBase = $dirBase . $entryBase;
			$filenameCopy = $dirCopy . $entryBase;
			if(is_file($filenameBase)) {
				if (copy($filenameBase, $filenameCopy)) {
//					echo('Copie de ' . $filenameBase . ' vers ' . $filenameCopy . ' réussie<br>');
				}
			}
		}
		closedir($handleBase);
	}
//echo ('<br><br>');
}

ReplaceFiles('./www/Condominium/pdf-base/', './www/Condominium/pdf/');
ReplaceFiles('./www/Condominium/pho-base/', './www/Condominium/pho/');