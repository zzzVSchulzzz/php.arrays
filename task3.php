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

// Функция определения пола по ФИО
function getGenderFromName($fullname){
	
	//Получаем части имени
	$parts = getPartsFromFullname($fullname);
	//Задаем «суммарный признак пола» 
	$genderScore = 0;
	
	//Проверка признаков женского пола
	if (mb_substr($parts['patronymic'], -3) === "вна"){
		$genderScore--;
	}
	
	if (mb_substr($parts['name'], -1) === "а"){
		$genderScore--;
	}
	
	if (mb_substr($parts['surname'], -2) === "ва"){
		$genderScore--;
	}
	
	//Проверка признаков мужского пола
	if (mb_substr($parts['patronymic'], -3) === "ич"){
		$genderScore++;
	}
	
	if (mb_substr($parts['name'], -1) === "й" || mb_substr($parts['name'], -1) === "н"){
		$genderScore++;
	}
	
	if (mb_substr($parts['surname'], -2) === "в"){
		$genderScore++;
	}
	
	
    // Определяем пол на основании значения genderScore
    if ($genderScore > 0) {
        return 1; // Мужской пол
    } elseif ($genderScore < 0) {
        return -1; // Женский пол
    } else {
        return 0; // Неопределенный пол
    };

};

//Перебираем массив

foreach($example_persons_array as $person) {
	
	//Получаем сведения о гендере
	$gender = getGenderFromName($person['fullname']);
	
	//Выводим свендения о гендере
	switch ($gender){
		 case 1:
		 	echo "{$person['fullname']} - мужчина\n";
		 	break;
		 case -1:
		 	echo "{$person['fullname']} - женщина\n";
		 	break;
		 case 0:
		 	echo "{$person['fullname']} - не удалось определить пол\n";
		 	break;
	}
	
};
?>
