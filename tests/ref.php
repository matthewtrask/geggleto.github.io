<?php
/**
 * Created by PhpStorm.
 * User: Glenn
 * Date: 2015-12-01
 * Time: 9:48 AM
 */

class A {
    public $z = 10;
}

$a1 = new A();

$z = &$a1->z;

$a2 = clone $a1;

$a3 = clone $a2;

$a1->z = 11;

var_dump($z);

$a2->z = 12;

var_dump($z);

unset($a3->z);
$a3->z = 13;
var_dump($z);
var_dump($a3->z);