<?php
header('Content-Type: text/html; charset=utf-8'); // Установка заголовка для кодировки

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

//Функция разрозненного представления имени в рамках массива
function getPartsFromFullname($fullname) {
 $parts = explode(' ', $fullname);
 
 //Возвращаем массив с новыми ключами 
 return [
  'surname' => $parts[0],
  'name' => $parts[1],
  'patronymic' => $parts[2]
 ];
};

// Функция формирования сокращенного имени
function getShortName($name, $surname){
 return "{$name} {$surname[0]}.";
};

//Перебираем массив

foreach($example_persons_array as $person) {
 
 //Получаем части имени
 $parts = getPartsFromFullname($person['fullname']);
 
 //Собираем сокращенное имя
 $shortName = getShortName($parts['name'], $parts['surname']);
    
    echo "Собранное полное имя: $shortName\n\n"; 
 
};
?>
