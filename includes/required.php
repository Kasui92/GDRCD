<?php
session_start();

require_once(dirname(__FILE__) . '/constant_values.inc.php');

/**
 * Includo i parametri di configurazione per GDRCD
 * N.B.: predispongo la possibilità di includere un file di override per i parametri
 * così da poterli modificare senza dover modificare il file originale
 */
require_once(dirname(__FILE__) . '/../config.inc.php');
if(file_exists(dirname(__FILE__).'/config-overrides.php')){
    include_once dirname(__FILE__).'/config-overrides.php';
}

/**
 * Includo i metodi per la gestione delle migrazioni del database
 */
require_once dirname(__FILE__) . '/DbMigration/DbMigrationEngine.class.php';
require_once dirname(__FILE__) . '/DbMigration/DbMigration.class.php';

/**
 * Includo la configurazione della localizzazione
 */
require_once(dirname(__FILE__) . '/../vocabulary/' . $PARAMETERS['languages']['set'] . '.vocabulary.php');

/**
 * Includo le funzioni di base
 */
require_once(dirname(__FILE__) . '/functions.inc.php');

/**
 * Includo le funzioni per la gestione dei suoni
 */
require_once(dirname(__FILE__) . '/AudioController.class.php');

// Salva il tema scelto dall'utente in una variabile di sessione
if(!empty($_SESSION['theme']) and array_key_exists($_SESSION['theme'], $PARAMETERS['themes']['available'])){
    $PARAMETERS['themes']['current_theme'] = $_SESSION['theme'];
}
