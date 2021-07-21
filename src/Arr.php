<?php

namespace Punk\Support;

/**
 * Arr
 * PHP version 7.4
 *
 * @category Support
 * @package  Punk\Support
 * @author   Rafael Pereira <rafaelrufino>
 * @license  http://www.gnu.org/copyleft/gpl.html GPL 
 */
class Arr {

    /**
     * Verificar se uma chave existe no array
     * @param int|string $key chave procurada
     * @param array $array array fonte da procura
     * @return bool
     * */
    public static function key_exists($key, Array $array): bool {
        return array_key_exists($key, $array);
    }

    /**
     * Verificar se um array é associativo
     * @param array $array array fonte da procura
     * @return bool
     * */
    public static function array_is_association(Array $array): bool {
        return static::is_association(static::key_first($array));
    }

    /**
     * Verificar se uma chave do array é associativa
     * @param string|int $key chave
     * @return bool
     * */
    public static function is_association($key): bool {
        return !is_int($key);
    }

    /**
     * Retorna a chave do primeiro elemento do Array
     * @param array $array array fonte da procura
     * @return string|int|mixed
     * */
    public static function key_first(Array $array) {
        return array_key_first($array);
    }

    /**
     * Retorna as chave
     * @param array $array array fonte da procura
     * @return string|int|mixed
     * */
    public static function keys(Array $array) {
        return array_keys($array);
    }

    /**
     * Efetua pesquisa em um array
     * @param array|mixed $array array onde será realizado a pesquisa
     * @param Closure $callback callback a cada interação do array
     * @return array
     * */
    public static function queryBy($array, $callback): Array {
        $response = array();
        $index = 0;
        foreach (static::toArray($array) as $key => $value) {
            $index = $index + 1;
            if ($callback($value, $key, $index)) {
                if (self::is_association($key)) {
                    $response[$key] = $value;
                } else {
                    $response[] = $value;
                }
            }
        }

        return $response;
    }

    /**
     * Transforma qualquer valor recebido em array
     * @param array|mixed $value 
     * @return array
     * */
    public static function toArray($value): Array {
        if (is_array($value) == false) {
            if ($value) {
                return array($value);
            } else {
                return array();
            }
        }
        return $value;
    }

}

class_alias(Arr::class, 'Punk_Support_Array');
