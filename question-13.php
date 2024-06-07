<?php

$data = [
    'name' => 'Jay',
    'gender' => 'female',
];

$serializedData = serialize($data);

$compressedData = gzcompress($serializedData);

$filename = 'compressed_data.dat';
file_put_contents($filename, $compressedData);

echo "Data serialized, compressed, and saved to file: $filename" . PHP_EOL;

$readData = file_get_contents($filename);

$decompressedData = gzuncompress($readData);

$unserializedData = unserialize($decompressedData);

echo "Data unserialized and decompressed from file:" . PHP_EOL;
print_r($unserializedData);
?>
