<?php

namespace Ganti\i18next\Test;

use PHPUnit\Framework\TestCase;
use Ganti\i18next;

final class suiteTest extends TestCase {

    private function setupTest() {
        i18next::init('en', 'example/', '{{x}}');
    }

    public function testInitFail() {
        $this->expectException(\Exception::class);
        i18next::init('en', 'not found');
    }

    public function testBasics() {
        $this->setupTest();

        // Simple
        $this->assertSame('dog', i18next::getTranslation('animal.dog'));

        // With count
        $this->assertSame('1 cat', i18next::getTranslation('animal.catWithCount', ['count' => 1]));
    }

    public function testPlural() {
        $this->setupTest();

        // Simple plural
        $this->assertSame('dogs', i18next::getTranslation('animal.dog', ['count' => 2]));
    }

    public function testModifiers() {
        $this->setupTest();

        // Plural with language override
        $this->assertSame('koiraa', i18next::getTranslation('animal.dog', ['count' => 2, 'lng' => 'fi']));

        // Context
        $this->assertSame('A girlfriend', i18next::getTranslation('friend', ['context' => 'female']));

        // Context with plural
        $this->assertSame('100 girlfriends', i18next::getTranslation('friend', ['context' => 'female', 'count' => 100]));

        // Multiline object
        $this->assertSame(19, count(i18next::getTranslation('animal.thedoglovers', ['returnObjectTrees' => true])));
    }

}