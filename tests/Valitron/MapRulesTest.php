<?php
use Valitron\Validator;


class MapRulesTest extends BaseTestCase
{
    public function testMapSingleFieldRules()
    {

        $rules = array(
            'required',
            array('lengthMin', 4)
        );

        $v = new Validator(array());
        $v->mapFieldRules('myField', $rules);
        $this->assertFalse($v->validate());
        $this->assertEquals(2, sizeof($v->errors('myField')));

        $v2 = new Validator(array('myField' => 'myVal'));
        $v2->mapFieldRules('myField', $rules);
        $this->assertTrue($v2->validate());
    }

    public function testSingleFieldDot()
    {

        $v = new Valitron\Validator(array(
            'settings' => array(
                array('threshold' => 50),
                array('threshold' => 90)
            )
        ));
        $v->mapFieldRules('settings.*.threshold', array(
            array('max', 50)
        ));
        
        $this->assertFalse($v->validate());

    }

    public function testMapMultipleFieldsRules()
    {
        $rules = array(
            'myField1' => array(
                'required',
                array('lengthMin', 4)
            ),
            'myField2' => array(
                'required',
                array('lengthMin', 5)
            )
        );

        $v = new Validator(array(
            'myField1' => 'myVal'
        ));
        $v->mapFieldsRules($rules);

        $this->assertFalse($v->validate());
        $this->assertFalse($v->errors('myField1'));
        $this->assertEquals(2, sizeof($v->errors('myField2')));

    }
}