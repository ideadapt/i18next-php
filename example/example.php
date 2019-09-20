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

echo '<br>'.PHP_EOL.PHP_EOL. 	'animal.dog -> ' . t('animal.dog');

echo '<br>'.PHP_EOL.PHP_EOL. 	'animal.cat { count: 0 } -> ' . t('animal.cat', array('count' => 0));
echo '<br>'.PHP_EOL.		 	'animal.cat { count: 1 } -> ' . t('animal.cat', array('count' => 1));
echo '<br>'.PHP_EOL. 			'animal.cat { count: 2 } -> ' . t('animal.cat', array('count' => 2));
echo '<br>'.PHP_EOL.PHP_EOL. 	'animal.cat { count: 2, lng: fi } -> ' . t('animal.cat', array('count' => 2, 'lng' => 'fi'));

echo '<br>'.PHP_EOL.PHP_EOL. 	'animal.elephant { count: 0 } -> ' . t('animal.elephant', 0);
echo '<br>'.PHP_EOL. 			'animal.elephant { count: 1 } -> ' . t('animal.elephant', 1);
echo '<br>'.PHP_EOL. 			'animal.elephant { count: 2 } -> ' . t('animal.elephant', 2);

echo '<br>'.PHP_EOL.PHP_EOL. 	'animal.spiderWithCount { count: 0 } -> ' . t('animal.spiderWithCount', 0);
echo '<br>'.PHP_EOL. 			'animal.spiderWithCount { count: 1 } -> ' . t('animal.spiderWithCount', 1);
echo '<br>'.PHP_EOL. 			'animal.spiderWithCount { count: 55 } -> ' . t('animal.spiderWithCount', 55);

echo '<br>'.PHP_EOL.PHP_EOL. 	'common.name_age { name: Elisa, age: 32 } -> ' . t('common.name_age', array('name' => "Elisa", "age" => 32));

echo PHP_EOL.PHP_EOL.			'<hr>Array: multiline.poem -><br>'.PHP_EOL;
echo 							str_replace("\n", '<br>', t('multiline.poem_kafka', ['truth' => 'Truth', 'lie' => 'lie', 'lies' => 'lies']));
