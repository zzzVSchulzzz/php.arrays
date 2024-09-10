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
	echo "\n Количество мужчин: {$genderDistribution['мужчины']} ({$genderDistribution['мужские_доля']}%)\n ";
	echo "Количество женщин: {$genderDistribution['женщины']} ({$genderDistribution['женские_доля']}%)\n ";
	echo "Количество с неопределенным полом: {$genderDistribution['неопределенный']} ({$genderDistribution['неопределенные_доля']}%)\n ";
?>
