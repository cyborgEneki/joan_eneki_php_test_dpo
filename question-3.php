<?php

class CustomException extends Exception
{
    public function errorMessage()
    {
        $errorMsg = "Error on line {$this->getLine()} in {$this->getFile()}: {$this->getMessage()}" . PHP_EOL;
        return $errorMsg;
    }
}

try {
    $number = 0;

    if ($number <= 0) {
        throw new CustomException("The number must be greater than zero.");
    }

    echo "The number is valid."  . PHP_EOL;
} catch (CustomException $e) {
    echo $e->errorMessage();
}
