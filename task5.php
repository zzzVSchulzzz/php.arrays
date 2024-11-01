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
function getFullnameFromParts($surname, $name, $patronymic) {
	return "{$surname} {$name} {$patronymic}";
}

//Функция разрозненного представления имени в рамках массива
function getPartsFromFullname($fullname) {
	$parts = explode(' ', $fullname);
	
	//Возвращаем массив с новыми ключами 
	return [
		'surname' => $parts[0],
		'name' => $parts[1],
		'patronymic' => $parts[2]
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
	$reconstructedFullname = getFullnameFromParts($parts['surname'], $parts['name'], $parts['patronymic']);
    echo "Собранное полное имя: $reconstructedFullname\n\n"; 
		
};

// Функция формирования сокращенного имени
function getShortName($name, $surname){
 return "{$name} " . mb_substr($surname, 0, 1) . ".";
};

//Перебираем массив

foreach($example_persons_array as $person) {

//Получаем части имени
$parts = getPartsFromFullname($person['fullname']);

//Собираем сокращенное имя
$shortName = getShortName($parts['name'], $parts['surname']);
echo "Собранное полное имя: $shortName\n\n"; 

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
	
	if (mb_substr($parts['name'], -1) === "а" || mb_substr($parts['name'], -1) === "я"){
		$genderScore--;
	}
	
	if (mb_substr($parts['surname'], -2) === "ва"){
		$genderScore--;
	}
	
	//Проверка признаков мужского пола
	if (mb_substr($parts['patronymic'], -3) === "ич"){
		$genderScore++;
	}
	
	if (mb_substr($parts['name'], -1) <=> "й" || mb_substr($parts['name'], -1) <=> "н"){
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

// Функция определения полового состава аудитории
function getGenderDescription($persons) {
    $total = count($persons);
    if ($total === 0) {
        return "Нет участников.";
    }

    // Фильтруем массив, чтобы получить количество мужчин, женщин и неопределенных
    $maleCount = count(array_filter($persons, function($person) {
        return getGenderFromName($person['fullname']) === 1;
    }));

    $femaleCount = count(array_filter($persons, function($person) {
        return getGenderFromName($person['fullname']) === -1;
    }));

    $unknownCount = count(array_filter($persons, function($person) {
        return getGenderFromName($person['fullname']) === 0;
    }));

    // Вычисляем процент мужчин, женщин и неопределенного пола
    $malePercent = round(($maleCount / $total) * 100, 2);
    $femalePercent = round(($femaleCount / $total) * 100, 2);
    $unknownPercent = round(($unknownCount / $total) * 100, 2);

    return [
        'мужчины' => $maleCount,
        'женщины' => $femaleCount,
        'неопределенный' => $unknownCount,
        'мужские_доля' => $malePercent,
        'женские_доля' => $femalePercent,
        'неопределенные_доля' => $unknownPercent
    ];
};
	$genderDistribution = getGenderDescription($example_persons_array);
	echo "Гендерный состав аудитории:\n";
	echo "\n Количество мужчин: {$genderDistribution['мужчины']} ({$genderDistribution['мужские_доля']}%)\n ";
	echo "Количество женщин: {$genderDistribution['женщины']} ({$genderDistribution['женские_доля']}%)\n ";
	echo "Количество с неопределенным полом: {$genderDistribution['неопределенный']} ({$genderDistribution['неопределенные_доля']}%)\n ";

function getPerfectPartner($surname, $name, $patronymic, $persons) {
	$surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
	$name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
	$patronymic = mb_convert_case($patronymic, MB_CASE_TITLE_SIMPLE);
	$fullname = getFullnameFromParts($surname, $name, $patronymic);

	$initialGender = getGenderFromName($fullname);
	if ($initialGender === 0) {
		echo "\nНевозможно подобрать пару, так как пол $name неизвестен.\n";
		return;
	}
	
	if (empty($persons)) {
		echo "Нет доступных кандидатов.\n";
		return;
	}
	
	$partnerFound = false;
	while (!$partnerFound) {
		$partner = $persons[array_rand($persons)];
		$partnerGender = getGenderFromName($partner['fullname']);
		
		if ($partnerGender !==$initialGender && $partnerGender !== 0) {
			$partnerFound = true;
		}
	}

	// Выбираем рандомный % совместимости
	$perfectPercent = strval(rand(50, 100)).'.'. strval(rand(0, 9)) . strval(rand(0, 9)) .'%';

	$parts = getPartsFromFullname($fullname);
	$partnerParts = getPartsFromFullname($partner["fullname"]);
	
	$initShortName = getShortName($parts['name'], $parts['surname']);
	$partnerShortName = getShortName($partnerParts['name'], $partnerParts['surname']);
	echo "\n$initShortName + $partnerShortName = ♡ Идеально на $perfectPercent ♡\n";
};

foreach ($example_persons_array as $person) {
	$parts = getPartsFromFullname($person['fullname']);
	getPerfectPartner($parts['surname'], $parts['name'], $parts['patronymic'], $example_persons_array);
}

?>
