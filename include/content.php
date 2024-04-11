<div class="container mt-3">
    <h1>Телефонный справочник</h1>


<?php

$json = file_get_contents('data.json');
$objects = json_decode($json);

foreach ($objects as $object){
    $number=$object->number;
    $name =$object->name;
    $firstname=$object->firstname;
    $fio=mb_substr($name,0,1).' '.mb_substr($firstname,0,1);
    if($object->avatar!=null)
        $img='<img src="'.$object->avatar.'" class="img-fluid rounded-start" alt="...">';
    else $img='<svg xmlns="http://www.w3.org/2000/svg"
    width="180"
     height="180"
     viewBox="0 0 50 50">
     <rect fill="#dedede"
          width="50"
          height="50"/>
     <text fill="rgba(0,0,0,0.6)"
          font-family="sans-serif"
          font-size="20"
          dy="8"
          font-weight="bold"
          x="50%"
          y="50%"
          text-anchor="middle"> '.$fio.'
     </text>
</svg>';
    echo '
            <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                '.$img.'
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">'.$name,' ', $firstname.' </h5>
                    <p class="card-text"><small class="text-body-secondary">' . $number . '</small></p>
                </div>
            </div>
            <div class="card-footer bg-transparent border-success d-flex justify-content-end">
            <form class="ms-3" action="alter.php" method="get">
                    <button type="submit" value="' . $number . '" name="contact" class="btn btn-success">Изменить</button>
                    </form>
                    <form class="ms-3" action="script/delete.php" method="get">
                    <button type="submit" value="' . $number . '" name="contact" class="btn btn-danger">Удалить</button>
                    </form>
</div>
        </div>
    </div>';
}
?>
</div>
