<?php

namespace App\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Venta;

class VentasImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        $fechaExcel = $row['fecha']; // Asumimos que 'fecha' es la columna con la fecha

        // Verificamos si el valor de la fecha es un número
        if (is_numeric($fechaExcel)) {
            // Convertimos el número de serie de Excel a una fecha con Carbon
            $fecha = Carbon::createFromFormat('Y-m-d', Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaExcel))->format('Y-m-d'));
        } else {
            // Si la fecha ya está en formato correcto, la dejamos tal cual
            $fecha = $fechaExcel;
        }

        return new Venta([
            'fecha' => $fecha,
            'nro_reci' => $this->parseNumero($row['nro_reci']), 
            'nombre' => $row['nombre'],
            'peso'   => $this->parseNumero($row['peso']),
            'precio' => $this->parseNumero($row['precio']),
            'monto'  => $this->parseNumero($row['monto']),
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'fecha' => 'nullable',
            'nro_reci' => 'required|integer', 
            'nombre' => 'required|string',
            'peso' => 'nullable',
            'precio' => 'nullable',
            'monto' => 'nullable',
        ];
    }

    private function isValidDate($date)
{
    // Aquí podrías usar una expresión regular o simplemente probar el formato
    $d = Carbon::createFromFormat('m/d/Y', $date);
    return $d && $d->format('m/d/Y') === $date;
}

    /**
     * Convierte un valor numérico de Excel a formato float
     */
    private function parseNumero($valor)
    {
        // Limpia el valor para manejar formatos con comas, espacios, símbolos de moneda, etc.
        if (is_string($valor)) {
            $limpio = preg_replace('/[^\d.,]/', '', $valor);
            $limpio = str_replace(',', '.', $limpio);
            
            // Si hay varios puntos decimales (como en 1.234.56), solo deja el último
            $partes = explode('.', $limpio);
            if (count($partes) > 2) {
                $ultimaParte = array_pop($partes);
                $limpio = implode('', $partes) . '.' . $ultimaParte;
            }
            
            return is_numeric($limpio) ? (float)$limpio : null;
        }
        
        return is_numeric($valor) ? (float)$valor : null;
    }
}
