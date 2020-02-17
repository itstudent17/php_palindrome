<?php
/**
 * Функция выводит окончательный результат в зависимости
 * от наличия палиндрома в строке-аргументе.
 *
 * @param $string
 */
function getPalindrome($string) {
    $str = prepareString($string);
    if (isFullStringPalindrome($str)) echo $string . '<br>';
    else if (getSubPalindrome($str)) echo getSubPalindrome($str) . '<br>';
    else echo mb_substr($string, 0, 1, 'utf-8') . '<br/>';
}

/**
 * Убирает пробелы из исходной строки.
 * @param $string
 * @return false|string
 */
function prepareString($string) {
    $length = iconv_strlen($string);
    $str = implode('', explode(' ', $string));
    $str = iconv_substr($str, 0, $length, 'utf-8');
    return $str;
}

/**
 * Проверяет, является ли передаваемая строка палиндромом путем
 * сравнения двух строк (строки-аргумента и строки-аргумента,
 * записанной в обратном порядке) с приведением к нижнему регистру.
 *
 * @param $string
 * @return bool
 */
function isFullStringPalindrome($string) {
    preg_match_all('/./us', $string, $ar);
    $str = join('', $ar[0]);
    $reversedStr = join('', array_reverse($ar[0]));
    return mb_strtolower($str) === mb_strtolower($reversedStr);
}

/**
 * Находит палиндромы в подстроках строки-аргумента и возвращает либо
 * подстроку с максимальной длиной, либо false.
 *
 * @param $str
 * @return mixed
 */
function getSubPalindrome($str) {
    $arr = [];

    $length = iconv_strlen($str, 'utf-8');

    for ($m = 0; $m < $length; $m++) {
        for ($n = $length - 1; $n >= 0 ; $n--) {
            $substr = iconv_substr($str, $m, $n, 'utf-8');
            if (
                iconv_strlen($substr, 'utf-8') > 1 &&
                !in_array($substr, $arr) &&
                isFullStringPalindrome($substr)
            ) $arr[] = $substr;
        }
    }

    if (count($arr)) {
        $longestStr = $arr[0];
        foreach ($arr as $value) {
            if (iconv_strlen($value, 'utf-8') > iconv_strlen($longestStr, 'utf-8')) $longestStr = $value;
        }
    }

    return $longestStr;
}
