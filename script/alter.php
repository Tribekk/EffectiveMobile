<?php
session_start();
$json = file_get_contents('data.json');
$filename = 'data.json';
$contacts = json_decode($json);

if(isset($_POST['create'])){
    $name = $_POST['name'];
    $firstname = $_POST['firstname'];
    $number = $_POST['number'];
    if ($number == '')
        $_SESSION['error'] = 'Номер обязателен';
    $file_name = $_SESSION['avatar'];
    if ($_FILES['avatar']['error'] == 0) {
        $file_name = 'avatar/' . Date('YmdGis') . ".jpg";
        $tmp_name = $_FILES['avatar']['tmp_name'];
        move_uploaded_file($tmp_name, $file_name);
    }
    $json = file_get_contents('data.json');
    $filename = 'data.json';
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
    $json = file_get_contents('data.json');
    $objects = json_decode($json);
    if (isset($objects))
        foreach ($objects as $object)
            if ($object->number == $number)
                $_SESSION['error'] = 'Такой номер уже записан';
    if (!isset($_SESSION['error'])) {
        $array = [
            "name" => $name,
            "firstname" => $firstname,
            "number" => $number,
            "avatar" => $file_name
        ];
        $json = json_encode($array, JSON_UNESCAPED_UNICODE);
        $filename = 'data.json';
        $payload = file_exists($filename) ? ",{$json}]" : "[{$json}]";
        $fileHandler = fopen($filename, "c");
        fseek($fileHandler, -1, SEEK_END);
        fwrite($fileHandler, $payload);
        fclose($fileHandler);
    }
    header('Location: index.php');
}