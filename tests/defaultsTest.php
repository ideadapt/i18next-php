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

    public function testSimpleTranslation() {
        $this->setupTest();

        $this->assertEquals('dog', i18next::getTranslation('animal.dog'));
    }

    public function testPluralNestedKeys() {
        $this->setupTest();

        // dog_plural
        $this->assertEquals('dogs', i18next::getTranslation('animal.dog', ['count' => 2]));

        // cat_plural_0
        $this->assertEquals('0 cats', i18next::getTranslation('animal.cat', ['count' => 0]));

        //elephant_0
        $this->assertEquals('no elephants', i18next::getTranslation('animal.elephant', ['count' => 0]));

        $this->assertEquals('Elisa is 32 years old', i18next::getTranslation('common.name_age', array('name' => "Elisa", "age" => 32)));
        // Plural with language override
        $this->assertEquals('Elisa on 32-vuotias', i18next::getTranslation('common.name_age', array('name' => "Elisa", "age" => 32, 'lng' => 'fi')));
        $this->assertEquals('koiraa', i18next::getTranslation('animal.dog', ['count' => 2, 'lng' => 'fi']));
    }

    public function testContext() {
        $this->assertEquals('A friend', i18next::getTranslation('people.friend'));

        // Context
        $this->assertEquals('A girlfriend', i18next::getTranslation('people.friend', ['context' => 'female']));

        // Context with plural
        $this->assertEquals('100 girlfriends', i18next::getTranslation('people.friend', ['context' => 'female', 'count' => 100]));
        $this->assertEquals('no boyfriend', i18next::getTranslation('people.friend', ['context' => 'male', 'count' => 0]));
        $this->assertEquals('100 boyfriends', i18next::getTranslation('people.friend', ['context' => 'male', 'count' => 100]));
    }

    public function testMultiline() {
        // Multiline object - count lines
        $this->assertEquals(5, count(i18next::getTranslation('multiline.poem_kafka', ['returnObjectTrees'=>true, 'truth' => 'Truth', 'lie' => 'lie', 'lies' => 'lies'])));

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