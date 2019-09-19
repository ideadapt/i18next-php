<?php

use Ganti\i18next;
use PHPUnit\Framework\TestCase;

final class I18nextTest extends TestCase {

    public function testWithDefaults_loadsTranslationFileWithNamespaceEN() {
        i18next::init();
        $this->assertEquals('empty', i18next::getTranslation('key'));
    }

    public function testWithLanuage_loadsTranslationFileWithNamespaceFR() {
        i18next::init('fr');
        $this->assertEquals('fr', i18next::getTranslation('key'));
    }

    public function testWithLanuageAndPathLangPlaceholders_loadsTranslationFRFile() {
        i18next::init('fr', './translation__lng__.json');
        $this->assertEquals('fr', i18next::getTranslation('key'));
    }

    // ...
}

