--TEST--
PHP Spec test generated from ./expressions/bitwise_and,_or,_xor_operators/bitwise_and_or_xor.php
--FILE--
<?php

/*
   +-------------------------------------------------------------+
   | Copyright (c) 2014 Facebook, Inc. (http://www.facebook.com) |
   +-------------------------------------------------------------+
*/

error_reporting(-1);

// check for even integer values by inspecting the low-order bit

for ($i = -5; $i <= 5; ++$i)
	echo "$i is ".(($i & 1 == TRUE) ? "odd\n" : "even\n");

$upCaseLetter = 0x41;					// letter 'A'
$lowCaseLetter = $upCaseLetter | 0x20;	// set the 6th bit
printf("Lowercase equivalent of '%c' is '%c'\n", $upCaseLetter, $lowCaseLetter);

$lowCaseLetter = 0x73;					// letter 's'
$upCaseLetter = $lowCaseLetter & ~0x20;	// clear the 6th bit
printf("Uppercase equivalent of '%c' is '%c'\n", $lowCaseLetter, $upCaseLetter);

// swap two integers

$v1 = 1234; $v2 = -987;
printf("\$v1 = $v1, \$v2 = $v2\n", $v1, $v2);
$v1 = $v1 ^ $v2;
$v2 = $v1 ^ $v2;
$v1 = $v1 ^ $v2;
printf("\$v1 = $v1, \$v2 = $v2\n", $v1, $v2);

printf("0b101101 & 0b111 = 0b%b\n", 0b101111 & 0b101);
printf("0b101101 | 0b111 = 0b%b\n", 0b101111 | 0b101);
printf("0b101101 ^ 0b111 = 0b%b\n", 0b101111 ^ 0b101);

// Test all kinds of scalar values to see which are ints or can be implicitly converted

$scalarValueList = array(10, -100);//, 0, 1.234, 0.0, TRUE, FALSE, NULL, "123", 'xx', "");
foreach ($scalarValueList as $v)
{
	printf("%b & 123 = %b\n", $v, $v & 123);
	printf("%b | 123 = %b\n", $v, $v | 123);
	printf("%b ^ 123 = %b\n", $v, $v ^ 123);
}
--EXPECT--
-5 is odd
-4 is even
-3 is odd
-2 is even
-1 is odd
0 is even
1 is odd
2 is even
3 is odd
4 is even
5 is odd
Lowercase equivalent of 'A' is 'a'
Uppercase equivalent of 's' is 'S'
$v1 = 1234, $v2 = -987
$v1 = -987, $v2 = 1234
0b101101 & 0b111 = 0b101
0b101101 | 0b111 = 0b101111
0b101101 ^ 0b111 = 0b101010
1010 & 123 = 1010
1010 | 123 = 1111011
1010 ^ 123 = 1110001
1111111111111111111111111111111111111111111111111111111110011100 & 123 = 11000
1111111111111111111111111111111111111111111111111111111110011100 | 123 = 1111111111111111111111111111111111111111111111111111111111111111
1111111111111111111111111111111111111111111111111111111110011100 ^ 123 = 1111111111111111111111111111111111111111111111111111111111100111
