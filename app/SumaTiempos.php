<?php
namespace App;

class SumaTiempos
{
    /**
     * Inicializamos el array que almacenara los valores del tiempo
     * @var Array
     */
    private $tiempo = array();
    /**
     * Constructor de clase
     * 
     * @param String $tiempo Tiempo que definimos
     */
    public function __construct($tiempo = '00:00:00')
    {
        list(
            $this->tiempo['horas'],
            $this->tiempo['minutos'],
            $this->tiempo['segundos']
            ) = explode(":", $tiempo);
    }
    /**
     * Sumamos el tiempo a otro
     * 
     * @param  SumaTiempos $tiempo Tiempo que queremos agregar
     */
    public function sumaTiempo(SumaTiempos $tiempo)
    {
        // Segundos
        $this->tiempo['segundos']
            = floatval($this->tiempo['segundos'])
            + floatval($tiempo->tiempo['segundos']);
        $minutos = intval($this->tiempo['segundos'] / 60);
        $this->tiempo['segundos'] -= $minutos * 60;
        // Minutos
        $this->tiempo['minutos']
            = intval($this->tiempo['minutos'])
            + intval($tiempo->tiempo['minutos'] + $minutos);
        $horas = intval($this->tiempo['minutos'] / 60);
        $this->tiempo['minutos'] -= $horas * 60;
        // Horas
        $this->tiempo['horas']
            = intval($this->tiempo['horas'])
            + intval($tiempo->tiempo['horas'] + $horas);
    }
    
    public function restaTiempo(SumaTiempos $tiempo)
    {
        // Segundos
        $this->tiempo['segundos']
            = floatval($tiempo->tiempo['segundos'])
            - floatval($this->tiempo['segundos']);
        $minutos = intval($this->tiempo['segundos'] / 60);
        $this->tiempo['segundos'] -= $minutos * 60;
        // Minutos
        $this->tiempo['minutos']
            = intval($tiempo->tiempo['minutos'] + $minutos)
            - intval($this->tiempo['minutos']);
        $horas = intval($this->tiempo['minutos'] / 60);
        $this->tiempo['minutos'] -= $horas * 60;
        // Horas
        $this->tiempo['horas']
            = intval($tiempo->tiempo['horas'] + $horas)
            - intval($this->tiempo['horas']);
    }
    
    /**
     * Formatea y devuelve el tiempo final
     *
     * @return String Tiempo final formateado
     */
    public function verTiempoFinal()
    {
        return sprintf(
            '%02s:%02s:%02s',
            $this->tiempo['horas'],
            $this->tiempo['minutos'],
            $this->tiempo['segundos']
        );
    }
}

?>