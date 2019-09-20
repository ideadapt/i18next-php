<?php

namespace Ganti\i18next\Test;
use Ganti\i18next;

use PHPUnit\Framework\TestCase;


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
        $this->assertSame('1 spider', i18next::getTranslation('animal.spiderWithCount', ['count' => 1]));

    }

    public function testPlural() {
        $this->setupTest();

        // dog_plural
        $this->assertSame('dogs', i18next::getTranslation('animal.dog', ['count' => 2]));
        
        // cat_plural_0
        $this->assertSame('0 cats', i18next::getTranslation('animal.cat', ['count' => 0]));
        
        //elephant_0
        $this->assertSame('no elephants', i18next::getTranslation('animal.elephant', ['count' => 0]));

        $this->assertSame('Elisa is 32 years old', i18next::getTranslation('common.name_age', array('name' => "Elisa", "age" => 32)));
        $this->assertSame('Elisa on 32-vuotias', i18next::getTranslation('common.name_age', array('name' => "Elisa", "age" => 32, 'lng' => 'fi')));

        

    }
    public function testContext() {

        $this->assertSame('A friend', i18next::getTranslation('people.friend'));

        // Context
        $this->assertSame('A girlfriend', i18next::getTranslation('people.friend', ['context' => 'female']));

        // Context with plural
        $this->assertSame('100 girlfriends', i18next::getTranslation('people.friend', ['context' => 'female', 'count' => 100]));
        $this->assertSame('no boyfriend', i18next::getTranslation('people.friend', ['context' => 'male', 'count' => 0]));
        $this->assertSame('100 boyfriends', i18next::getTranslation('people.friend', ['context' => 'male', 'count' => 100]));
    }

    public function testModifiers() {
        $this->setupTest();

        // Plural with language override
        $this->assertSame('koiraa', i18next::getTranslation('animal.dog', ['count' => 2, 'lng' => 'fi']));

    }

    public function testMultiline() {

        // Multiline object - count lines
        $this->assertSame(5, count(i18next::getTranslation('multiline.poem_kafka', ['returnObjectTrees'=>true, 'truth' => 'Truth', 'lie' => 'lie', 'lies' => 'lies'])));

        //Check Substitution - string
        $subst_var = ['truth' => 'Truth', 'lie' => 'lie', 'lies' => 'lies'];
        $trans_true = i18next::getTranslation('multiline.poem_kafka', $subst_var);
        $this->assertStringContainsString("There are only two things.\nTruth and lies.\nTruth is indivisible\n", $trans_true);
        $this->assertStringNotContainsString('{{truth}}', $trans_true);

        unset($subst_var['truth']);
        $trans_false = i18next::getTranslation('multiline.poem_kafka', $subst_var);
        $this->assertStringNotContainsString('There are only two things.\nTruth and lies.\nTruth is indivisibl\n', $trans_false);
        $this->assertStringContainsString('{{truth}}', $trans_false);

        //Missing Substitution - array
        $subst_var = ['returnObjectTrees' => true, 'truth' => 'Truth', 'lie' => 'lie', 'lies' => 'lies'];
        $trans_true = i18next::getTranslation('multiline.poem_kafka', $subst_var);
        $this->assertStringContainsString('Truth and lies.', $trans_true[1]);
        $this->assertStringNotContainsString('{{truth}}', $trans_true[1]);
        $this->assertStringNotContainsString('{{lies}}', $trans_true[1]);

        unset($subst_var['truth']);
        $trans_false = i18next::getTranslation('multiline.poem_kafka', $subst_var);
        $this->assertStringContainsString('{{truth}}', $trans_false[1]);
        $this->assertStringContainsString('{{truth}} and lies.', $trans_false[1]);
        $this->assertStringNotContainsString('{{lies}}', $trans_false[1]);
    }

}