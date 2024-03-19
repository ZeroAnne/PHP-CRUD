<?php
$letters = range('A', 'Z');


// 生成多个随机字母
$numberOfRandomLetters = 3; // 你可以根据需要更改此数量
$randomLettersString = '';
for ($i = 0; $i < $numberOfRandomLetters; $i++) {
    $randomLetter = $letters[array_rand($letters)];
    $randomLettersString .= $randomLetter;
    // echo "$randomLetter";
}
$letter = range('1', '2');
$number = 4;
$numberString = '';
for ($i = 0; $i < $number; $i++) {
    $Number = $letter[array_rand($letter)];
    $numberString .= $Number;
    // echo "$Number";
}
$codeRandom = $randomLettersString . $numberString;
echo $codeRandom;

?>
