<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Canal;
use Exception;

class CanalController extends Controller
{
    //
    public $xml_ruta = "";

    public function __construct() {
        $this->xml_ruta = env('XML_FILE_DIR');
    }


    private function cargarCanales()
    {
        $xml = $this->xml_ruta;
        $canales = [];


        try{
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
                            "type" => $typeValue
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
    }catch(Exception $e){
        return $canales;
    }

    }

    public function create(Request $request)
    {
        $key = $request->input('key');
        $value = $request->input('value');
        $type = $request->input('type');
        $number = $request->input('number');

        Canal::create([
            'key' =>   $key,
            'value' => $value,
            'type' => $type,
            'number' => $number

        ]);

        return redirect()->route('admin.canales')->with('success', 'El canal se ha creado con éxito.');
    }
    public function index(Request $request)
    {
        $canales_instalados = $this->cargarCanales();
        $canales = Canal::all();
        return view('canales.index')->with('canales', $canales)->with('canales_instalados', $canales_instalados);
    }

    public function edit($id)
    {
        $canal = Canal::find($id);
        return view('canales.edit')->with('canal', $canal);
    }

    public function update(Request $request, $id)
    {
        // Encuentra el canal a actualizar por su ID
        $canal = Canal::find($id);

        // Actualiza los campos del canal con los datos del formulario
        $canal->key = $request->input('key');
        $canal->value = $request->input('value');
        $canal->type = $request->input('type');
        $canal->number = $request->input('number');
        $canal->habilitado = $request->input('habilitado');

        // Guarda el canal actualizado en la base de datos
        $canal->save();

        return redirect()->route('admin.canales')->with('success', 'El canal se ha actualizado.');
    }

    public function destroy($id)
    {
        // Encuentra el canal a eliminar por su ID
        $canal = Canal::find($id);

        if ($canal) {
            // Elimina el canal de la base de datos
            $canal->delete();
            // Redirige o muestra un mensaje de éxito
            return 'Eliminado Exitosamente';
        } else {
            // Maneja el caso en el que el canal no se encuentra
            // Redirige o muestra un mensaje de error
            return 'Fallo la eliminacion';
        }
    }



    public function generarXML()
    {

        $canales_habilitados = Canal::where('habilitado', 1)->get();
        // Crear un nuevo objeto SimpleXMLElement con una raíz llamada "list"
        $xml = new \SimpleXMLElement('<?xml version="1.0"?> <?GXxml version=1.0?> <list></list>');
        foreach ($canales_habilitados as $canal) {
            $item1 = $xml->addChild('item');
            $item1->addChild('key', $canal->key);
            $item1->addChild('value', $canal->value);
            $item1->addChild('type', $canal->type);

            if ($canal->number != 0) {
                $item1->addChild('number', $canal->number);
            }
        }
        $xmlString = $xml->asXML();
        try {
            $archivo_canales = fopen($this->xml_ruta, "w");
            fwrite($archivo_canales, $xmlString);
            fclose($archivo_canales);
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
        }
        // Devolver una respuesta HTTP con el contenido XML
        return redirect()->route('admin.canales')->with('success', 'El archivo de canales se ha actualizado exitosamente.');
    }

    function retornarXML(){
        return response()->file($this->xml_ruta);
    }

}
