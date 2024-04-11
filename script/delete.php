<?php
$json = file_get_contents('../data.json');
$filename = '../data.json';
$contacts = json_decode($json);
foreach ($contacts as $index => $contact) {
    if ($contact->number == $_GET['contact']) {
        unset($contacts[$index]);
        break;
    }
}
unlink($filename);
foreach ($contacts as $contact){
    $array = [
        "name" => $contact->name,
        "firstname" => $contact->firstname,
        "number" => $contact->number,
        "avatar" => $contact->avatar
    ];
    $json=json_encode($array, JSON_UNESCAPED_UNICODE);
    $payload = file_exists($filename) ? ",{$json}]" : "[{$json}]";
    $fileHandler = fopen($filename, 'c');
    fseek($fileHandler, -1, SEEK_END);
    fwrite($fileHandler, $payload);
    fclose($fileHandler);
}
header('Location: ../index.php');