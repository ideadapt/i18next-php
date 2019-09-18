<?php

namespace Kopfwelt;

require_once('../src/i18next.php');

try {

	i18next::init('en');
	i18next::setSubstitutionBracket('{{x}}');

}
catch (Exception $e) {

	echo 'Caught exception: ' . $e->getMessage();

}

function t($key, $variables = array()) {

	return i18next::getTranslation($key, $variables);

}

echo 'common.dog -> ' . t('common.dog');

echo '<br>'.PHP_EOL;

echo 'common.cat { count: 1 } -> ' . t('common.cat', array('count' => 1));

echo '<br>'.PHP_EOL;

echo 'common.cat { count: 2 } -> ' . t('common.cat', array('count' => 2));

echo '<br>'.PHP_EOL;

echo 'common.cat { count: 2, lng: fi } -> ' . t('common.cat', array('count' => 2, 'lng' => 'fi'));

echo '<hr>Array: common.thedoglovers -><br>';

echo str_replace("\n", '<br>'.PHP_EOL, t('common.thedoglovers'));
