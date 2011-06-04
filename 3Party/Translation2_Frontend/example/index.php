<?php
require 'config.local.php';
require 'k.php';
require 'Root.php';
require 'Ilib/ClassLoader.php';

define('INTRAFACE_TOOLS_DB_DSN', 'mysql://' . DB_USER . ':' . DB_PASS . '@' . DB_HOST . '/' . DB_NAME);
define('DB_DSN', 'mysql://' . DB_USER . ':' . DB_PASS . '@' . DB_HOST . '/' . DB_NAME);

$application = new Root();

$application->registry->registerConstructor('translation_admin', create_function(
  '$className, $args, $registry',
  '
    $driver = "XML";
    $options = array(
        "filename"         => dirname(__FILE__) . "/i18n.xml",
        "save_on_shutdown" => true
    );
    $translation = Translation2_Admin::factory($driver, $options);
    if (PEAR::isError($translation)) {
        exit($translation->getMessage());
    }
    return $translation;
 '
));
$application->registry->registerConstructor('translation', create_function(
  '$className, $args, $registry',
  '
    $driver = "XML";
    $options = array(
        "filename"         => dirname(__FILE__) . "/i18n.xml",
        "save_on_shutdown" => true
    );
    $translation = Translation2::factory($driver, $options);
    if (PEAR::isError($translation)) {
        exit($translation->getMessage());
    }
    return $translation;
 '
));
$application->dispatch();