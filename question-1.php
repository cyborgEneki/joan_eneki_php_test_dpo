<?php

$country = 'Kenya';

$singleQuotedString = 'Kenya\'s my country.';
$doubleQuotedString = "{$country}'s my country. \n";

echo($doubleQuotedString);
echo($singleQuotedString) . PHP_EOL;
