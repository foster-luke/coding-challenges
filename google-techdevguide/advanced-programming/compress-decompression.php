<?php

//https://techdevguide.withgoogle.com/paths/advanced/compress-decompression#!

$input = '2[3[a]b]';
echo decompress($input);
echo "<br>";
echo ('aaabaaab' === decompress($input)) ? 'TRUE' : 'FALSE';


/**
 * decompress
 * 
 * Decompresses a compressed string, such as '2[3[a]b]' => 'aaabaaab'
 * https://techdevguide.withgoogle.com/paths/advanced/compress-decompression#!
 *
 * @param  mixed $input The compressed string
 * @return string The decompressed string
 */
function decompress(string $input) {
    $sectionEndPos = true;
    while ($sectionEndPos !== false) {
        // Get the position of the first end of section
        $sectionEndPos = strpos($input, ']');
        // Get the position of the start of that section
        $sectionStartPos = strrpos(substr($input, 0, $sectionEndPos), '[');
        // Get the number of loops for that section
        $beforeSectionString = str_split(substr($input, 0, $sectionStartPos));
        $loopCount = '';
        for ($i = $sectionStartPos - 1; $i >=0; $i--) {
            if (is_numeric($beforeSectionString[$i])) {
                $loopCount .= $beforeSectionString[$i];
            } else {
                break;
            }
        }
        $loopCount = (int) $loopCount;

        // Get the section of the string that needs to decompressed
        $compressedSection = substr($input, $sectionStartPos, $sectionEndPos - $sectionStartPos + 1);

        // Decompress that section
        $decompressedSection = str_repeat(substr($compressedSection, 1, -1), $loopCount);

        // Replace that section in the input string with the decompressed version
        $input = str_replace($loopCount . $compressedSection, $decompressedSection, $input);
    }
    return $input;
}
