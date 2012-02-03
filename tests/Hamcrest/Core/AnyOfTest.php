<?php
require_once 'Hamcrest/AbstractMatcherTest.php';
require_once 'Hamcrest/Core/AnyOf.php';
require_once 'Hamcrest/Core/SampleBaseClass.php';
require_once 'Hamcrest/Core/SampleSubClass.php';

class Hamcrest_Core_AnyOfTest extends Hamcrest_AbstractMatcherTest
{
  
  protected function createMatcher()
  {
    return Hamcrest_Core_AnyOf::anyOf('irrelevant');
  }
  
  public function testEvaluatesToTheLogicalDisjunctionOfTwoOtherMatchers()
  {
    assertThat('good', anyOf('bad', 'good'));
    assertThat('good', anyOf('good', 'good'));
    assertThat('good', anyOf('good', 'bad'));
    
    assertThat('good', not(anyOf('bad', startsWith('b'))));
  }
  
  public function testEvaluatesToTheLogicalDisjunctionOfManyOtherMatchers()
  {
    assertThat('good', anyOf('bad', 'good', 'bad', 'bad', 'bad'));
    assertThat('good', not(anyOf('bad', 'bad', 'bad', 'bad', 'bad')));
  }
  
  public function testSupportsMixedTypes()
  {
    $combined = anyOf(
      equalTo(new Hamcrest_Core_SampleBaseClass('good')),
      equalTo(new Hamcrest_Core_SampleBaseClass('ugly')),
      equalTo(new Hamcrest_Core_SampleSubClass('good'))
    );
    
    assertThat(new Hamcrest_Core_SampleSubClass('good'), $combined);
  }
  
  public function testHasAReadableDescription()
  {
    $this->assertDescription('("good" or "bad" or "ugly")',
      anyOf('good', 'bad', 'ugly')
    );
  }
  
}
