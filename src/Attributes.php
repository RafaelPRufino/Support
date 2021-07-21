<?php

namespace Punk\Support;

use \Punk\Support\Arr as Arr;
use \JsonSerializable;

/**
 * Attributes
 * PHP version 7.4
 *
 * @category Support
 * @package  Punk\Support
 * @author   Rafael Pereira <rafaelrufino>
 * @license  http://www.gnu.org/copyleft/gpl.html GPL 
 */
class Attributes implements JsonSerializable {

    /**
     * Bingding Changes Data
     * @return array
     * */
    protected $changes = [];

    /**
     * Bingding Attributes Data
     * @return array
     * */
    public $attributes = [];

    /**
     * Pega atributos que foram alterados 
     * @return array
     * */
    public function getAttributesChanges() {
        return $this->changes;
    }

    public function getAttributes() {
        return $this->attributes;
    }

    public function getAttributesNames() {
        return Arr::keys($this->attributes);
    }

    public function clearChanges(): void {
        $this->changes = [];
    }

    /**
     * Preenche uma classe com atributos vindos de array
     * @param Array $data
     * @return void
     * */
    public function fill($data): void {
        if (empty($data)) {
            return;
        }

        foreach ($data AS $key => $value) {
            if (!Arr::is_association($key)) {
                continue;
            }
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Pega o valor do atributo $key
     * @param string $key
     * @return mixed
     * */
    public function getAttribute(string $key) {
        if ($this->isAttribute($key)) {
            return $this->getAttributeValue($key);
        }

        if (method_exists(self::class, $key)) {
            return;
        }

        return null;
    }

    /**
     * Pega o valor do atributo $key
     * @param string $key atributo para qual deseja pegar valor
     * @return mixed
     * */
    protected function getAttributeValue(string $key) {
        if ($this->isAttribute($key)) {
            return $this->attributes[$key];
        }
        return null;
    }

    /**
     * Seta um valor para um atributo $key
     * @param string $key atributo para qual deseja passar valor
     * @return mixed
     * */
    public function setAttribute(string $key, $value) {
        return $this->setAttributeValue($key, $value);
    }

    /**
     * Seta um valor para um atributo $key
     * @param string atributo para qual deseja passar valor
     * @return mixed
     * */
    protected function setAttributeValue(string $key, $value) {
        $original = $this->getAttribute($key);
        $this->attributes [$key] = $value;

        if ($value != $original) {
            $this->changes[$key] = $this->attributes[$key];
        }

        return $this;
    }

    /**
     * Verifica se é um atributo padrão
     * @param string $key atributo para qual deseja passar valor
     * @return bool
     * */
    protected function isAttribute(string $key): bool {
        return isset($this->attributes[$key]) && Arr::key_exists($key, $this->attributes);
    }

    public function jsonSerialize() {
        return $this->attributes;
    }

}

class_alias(Attributes::class, 'Punk_Support_Attributes');