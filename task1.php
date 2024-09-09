<?php 
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

// Функция сбора имени из разрозненных частей
function getFullnameFromParts($surname, $name, $patronomyc) {
	return "{$surname} {$name} {$patronomyc}";
}

//Функция разрозненного представления имени в рамках массива
function getPartsFromFullname($fullname) {
	$parts = explode(' ', $fullname);
	
	//Возвращаем массив с новыми ключами 
	return [
		'surname' => $parts[0],
		'name' => $parts[1],
		'patronomyc' => $parts[2]
	];
}

//Перебираем массив

foreach($example_persons_array as $person) {
	$fullname = $person['fullname'];
	echo "$fullname\n";
	
	//Представляем части имени в виде единиц массива
	$parts = getPartsFromFullname($fullname);
	print_r($parts);
	
	//Собираем имя обратно
	$reconstructedFullname = getFullnameFromParts($parts['surname'], $parts['name'], $parts['patronomyc']);
    echo "Собранное полное имя: $reconstructedFullname\n\n"; 
		
};
?>
