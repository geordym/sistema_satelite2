<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CanalController extends Controller
{
    //
    public $xml_ruta = 'C:\xampp\htdocs\iptv_app\base.xml';


    private function cargarCanales()
    {
        $xml = $this->xml_ruta;
        $canales = [];

        if (file_exists($xml)) {
            $xml = simplexml_load_file($xml);
            if ($xml) {
                if (isset($xml->item)) {
                    foreach ($xml->item as $item) {
                        $keyValue = strval($item->key);
                        $numberValue = strval($item->number); // Obtiene el valor de $item->number como una cadena
                        $valueValue = strval($item->value); // Obtiene el valor de $item->value como una cadena
                        $typeValue = strval($item->type); // Obtiene el valor de $item->type como una cadena

                        $canal = [
                            "key" => $keyValue,
                            "number" => $numberValue,
                            "value" => $valueValue,
                            "typeValue" => $typeValue
                        ];

                        $canales[] = $canal;
                    }

                    return $canales;
                } else {
                    echo "El elemento <item> no existe en el XML.";
                }
            } else {
                echo "No se pudo cargar el XML.";
            }
        }
    }


    public function index(Request $request)
    {
        $canales = $this->cargarCanales();
        return view('canales.index')->with('canales', $canales);
    }
}
