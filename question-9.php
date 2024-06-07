<?php
function countWordsInFile($filename)
{
    try {
        $file = fopen($filename, 'r');

        if (!$file) {
            throw new Exception("Unable to open file: $filename");
        }

        $content = fread($file, filesize($filename));

        fclose($file);

        $wordCount = str_word_count($content);

        return $wordCount;
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

$filename = 'example-file.txt';
$result = countWordsInFile($filename);

if (is_numeric($result)) {
    echo ("Total word count: $result");
    echo ("\n");
} else {
    echo ("Error: $result");
}
