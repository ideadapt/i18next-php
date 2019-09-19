<?php
namespace Ganti;
require_once('../src/i18next.php');

try {
	i18next::init($language ='en', $path=null, $substitutionBracket="{{x}}");
}
catch (Exception $e) {
	echo 'Caught exception: ' . $e->getMessage();
}

function t($key, $variables = array()) {
	return i18next::getTranslation($key, $variables);
}

echo '<br>'.PHP_EOL.PHP_EOL. 	'common.dog -> ' . t('common.dog');

echo '<br>'.PHP_EOL.PHP_EOL. 	'common.cat { count: 0 } -> ' . t('common.cat', array('count' => 0));
echo '<br>'.PHP_EOL.		 	'common.cat { count: 1 } -> ' . t('common.cat', array('count' => 1));
echo '<br>'.PHP_EOL. 			'common.cat { count: 2 } -> ' . t('common.cat', array('count' => 2));

echo '<br>'.PHP_EOL.PHP_EOL. 	'common.elephant { count: 0 } -> ' . t('common.elephant', 0);
echo '<br>'.PHP_EOL. 			'common.elephant { count: 1 } -> ' . t('common.elephant', 1);
echo '<br>'.PHP_EOL. 			'common.elephant { count: 2 } -> ' . t('common.elephant', 2);


echo '<br>'.PHP_EOL.PHP_EOL. 	'common.cat { count: 2, lng: fi } -> ' . t('common.cat', array('count' => 2, 'lng' => 'fi'));

echo '<br>'.PHP_EOL.PHP_EOL. 	'common.name_age { name: Elisa, age: 32 } -> ' . t('common.name_age', array('name' => "Elisa", "age" => 32));

echo PHP_EOL.PHP_EOL.			'<hr>Array: common.thedoglovers -><br>'.PHP_EOL;
echo 							str_replace("\n", '<br>', t('common.thedoglovers', array('animal' => 'cat')));
echo '<br>'.PHP_EOL.PHP_EOL;