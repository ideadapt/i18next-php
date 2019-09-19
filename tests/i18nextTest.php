<?php
namespace Ganti\i18next\Test;

use Ganti\i18next;
use PHPUnit\Framework\TestCase;

final class I18nextTest extends TestCase {

    function dir(){ return __DIR__.'/'; }

    // File & Language
    public function testWithDefaults_loadsTranslationFileWithNamespaceEN() {
        i18next::init(null, $this->dir());
        $this->assertEquals('empty', i18next::getTranslation('key'));
    }

    public function testWithLanuage_loadsTranslationFileWithNamespaceFR() {
        i18next::init('fr', $this->dir());
        $this->assertEquals('fr', i18next::getTranslation('key'));
    }

    public function testWithLanguageAndPathLangPlaceholder_loadsTranslationFRFile() {
        i18next::init('fr', $this->dir().'translation-__lng__.json');
        $this->assertEquals('fr', i18next::getTranslation('key'));
    }

    public function testWithoutLanguageAndPathLangPlaceholder_loadsTranslationENFile() {
        i18next::init(null, $this->dir().'translation-__lng__.json');
        $this->assertEquals('en', i18next::getTranslation('key'));
    }

    // Plural
    public function testPlural_Singular() {
        i18next::init('en', $this->dir().'translation-__lng__.json');
        $this->assertEquals('a dog', i18next::getTranslation('dog'));
    }

    public function testPlural_Number() {
        i18next::init('en', $this->dir().'translation-__lng__.json');
        $this->assertEquals('two dogs (2)', i18next::getTranslation('dog', array('count' => 2)));
    }

    public function testPlural_Many() {
        i18next::init('en', $this->dir().'translation-__lng__.json');
        $this->assertEquals('many dogs (300)', i18next::getTranslation('dog', array('count' => 300)));
    }

    // Brackets && Variables
    public function testBrackets_ChangeToCurly() {
        i18next::init('en', $this->dir().'translation-__lng__.json');
        i18next::setSubstitutionBracket('{{x}}');
        // a _plural key can only exist, if its singular key (without _plural suffix) exists.
        $this->assertEquals('a dog', i18next::getTranslation('dog_curly'));
        $this->assertEquals('many curly dogs (300)', i18next::getTranslation('dog_curly', array('count' => 300)));
    }
}

