<?php
/**
 * In dieser Datei werden die Grundeinstellungen für WordPress vorgenommen.
 *
 * Zu diesen Einstellungen gehören: MySQL-Zugangsdaten, Tabellenpräfix,
 * Secret-Keys, Sprache und ABSPATH. Mehr Informationen zur wp-config.php gibt es
 * auf der {@link http://codex.wordpress.org/Editing_wp-config.php wp-config.php editieren}
 * Seite im Codex. Die Informationen für die MySQL-Datenbank bekommst du von deinem Webhoster.
 *
 * Diese Datei wird von der wp-config.php-Erzeugungsroutine verwendet. Sie wird ausgeführt,
 * wenn noch keine wp-config.php (aber eine wp-config-sample.php) vorhanden ist,
 * und die Installationsroutine (/wp-admin/install.php) aufgerufen wird.
 * Man kann aber auch direkt in dieser Datei alle Eingaben vornehmen und sie von
 * wp-config-sample.php in wp-config.php umbenennen und die Installation starten.
 *
 * @package WordPress
 */

/**  MySQL Einstellungen - diese Angaben bekommst du von deinem Webhoster. */
/**  Ersetze database_name_here mit dem Namen der Datenbank, die du verwenden möchtest. */
define('DB_NAME', 'usr_web163_7');

/** Ersetze username_here mit deinem MySQL-Datenbank-Benutzernamen */
define('DB_USER', 'root');

/** Ersetze password_here mit deinem MySQL-Passwort */
define('DB_PASSWORD', 'n3tpr0#12');

/** Ersetze localhost mit der MySQL-Serveradresse */
define('DB_HOST', 'localhost');

/** Der Datenbankzeichensatz der beim Erstellen der Datenbanktabellen verwendet werden soll */
define('DB_CHARSET', 'utf8');

/** Der collate type sollte nicht geändert werden */
define('DB_COLLATE', '');

/**#@+
 * Sicherheitsschlüssel
 *
 * Ändere jeden KEY in eine beliebige, möglichst einzigartige Phrase.
 * Auf der Seite {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * kannst du dir alle KEYS generieren lassen.
 * Bitte trage für jeden KEY eine eigene Phrase ein. Du kannst die Schlüssel jederzeit wieder ändern,
 * alle angemeldeten Benutzer müssen sich danach erneut anmelden.
 *
 * @seit 2.6.0
 */
define('AUTH_KEY',         '$6Xa;}eyB&T .j..,17`~Xnjr2:,1kWmE  S_@3 rifx.Qrc)-_VJ[F%nDen6.yA');
define('SECURE_AUTH_KEY',  'W3yT^>PL1iIuLWYbrRn};ibOSQd-yzJ(Y 0xYRTP{R{=]Ct@e+-n10kB=qn2kNDH');
define('LOGGED_IN_KEY',    '?on7?U0yA<,Gpkj(AG_/Dz[DVCVLpG9-_+wE+h7V7y|6cOC7-S#$+Z*a1@(DNemD');
define('NONCE_KEY',        '2JLc3-W@j4l7]qP|Q}FP|+wESc4Jm1S<Kue=(M0r+(65Ec2hg2#Mt=i^,9zFlX68');
define('AUTH_SALT',        'W}xk-(-Q|DV?Z_hZ3 d|5~t63iu/g jB6P_|NYkj%tGQI;1)n{O%1|crSIAA|X&c');
define('SECURE_AUTH_SALT', 'yO1XtmSJ<hCgtsYUQM|_8u; oC#/r:#4:^zfJQ?W=voU U|xn-{]LX&96gM5^;=R');
define('LOGGED_IN_SALT',   'j9r<|/4J*EGdYjd%Ie2Pghjo|oF9|5-p2%bN$R`6](,;JA_ndQDlh=6CSvZf?g#]');
define('NONCE_SALT',       '@C7nS=k] l=@]&K@Y>8mmW|>/| @&unIDRC[G%:i1nrOc;K<HkzkD+h|iWUp&PbM');

/**#@-*/

/**
 * WordPress Datenbanktabellen-Präfix
 *
 *  Wenn du verschiedene Präfixe benutzt, kannst du innerhalb einer Datenbank
 *  verschiedene WordPress-Installationen betreiben. Nur Zahlen, Buchstaben und Unterstriche bitte!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
