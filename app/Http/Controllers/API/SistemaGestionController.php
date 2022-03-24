<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\SistemaGestion;
use App\Models\proyectoevaluar;
use App\Http\Controllers\Controller;
use App\Http\Resources\SistemaGestion as SistemaGestionResource;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SistemaGestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*sistemaGestion = consulta de las metas  sgps con join en tre las tablas sistemagestion & proyectoevaluar*/
        $sistemaGestion = proyectoevaluar::select()
            ->Join('sistemagestion', 'proyectoevaluar.proyectoConsecutivo', '=', 'sistemagestion.codigoProyecto')
            ->where('sistemagestion.deleted_at', null)
            ->get()
            ->makeHidden(['created_at', 'updated_at', 'deleted_at'])
            ->toArray();


        $excel = new Spreadsheet();
        $excel->getProperties()
            ->setTitle('Sistema gestion sennova')
            ->setCreator("Grupo Sennova")
            ->setDescription('Informe Sistema gestion sennova');
        $hojaActiva = $excel->getActiveSheet();
        $hojaActiva->setTitle('Sistema gestion');

        /* TODO: Hacer las operaciones matematicas entre las celdas o el chart*/
        /* Cabecera */
        $cabeceras = [
            "codigo Proyecto",
            "proyecto Consecutivo",
            "Titulo del Proyecto",
            "Código regional",
            "Regional",
            "Código centro",
            "Centro de formación",
            "Descripcion Linea Programatica",
            "Mesa",
            "Laboratorio",
            "Nombre laboratorio",
            "Responsable servicios tecnologicos",
            "Evaluado?",
            "Codigo Proyecto",
            "Norma  implementada", //Pregunta1
            "Estado de implementación del sistema de gestión según norma",
            "Link",
            "Meta metodologías/servicios/productos aseguradas",
            "Link",
            "Metodologías/servicios/productos aseguradas",
            "Link",
            "Estado de reconocimiento de tecera parte (acraditación, certidicación o habilitación)",
            "Link",
            "Meta acreditación",
            "Link",
            "Cumplimiento meta acreditación",
            "Asesorías empresas",
            "Link",
            "Consultoría empresas",
            "Link",
            "Calibración, ensayo, st o se empresas",
            "Link",
            "Meta empresas atendidas",
            "Empresas atendidas x bimestre (seguimiento metas de gerente público oct) consultoría, asesoría, calibración,  ensayo, st o se",
            "Link",
            "Asesoría aprendices",
            "Link",
            "Consultoría aprendiz",
            "Link",
            "Transferencia - Aprendiz",
            "Link",
            "Calibración, ensayo, st o se aprendices",
            "Link",
            "Meta aprendices atendidos",
            "Aprendices atendidas x mes (seguimiento metas de gerente público oct) consultoría, asesoría o transferencia de conocimiento",
            "Porcentaje meta aprendices atendidos",
            "Asesoría emprendedores",
            "Link",
            "Consultoría emprendedores",
            "Link",
            "Transferencia emprendedores",
            "Link",
            "Calibración, ensayo, ST o SE-Emprendedores",
            "Link",
            "Emprendedores atendidos x bimestre",
            "Link",
            "Asesoría -personas",
            "Link",
            "Consultoría personas",
            "Link",
            "Calibración, ensayo, ST o SE",
            "Link",
            "Personas atendidas x mes",
            "Link",
            "Meta contratos de aprendizaje",
            "Contratos de apredizaje",
            "Link",
            "Programas de formación beneficiados por st",
            "Link",
            "EDT",
            "Nombre Edt",
            "Link",
            "Apr asignada",
            "APR Vigente",
            "Comprometido",
            "Link",
            "% Ejecución técnica",
            "Link",
            "Nombre Metodologia", //64
            "% Meta aprendices Atendidos",
            "% Meta empresas Atendidas",
            "Total asesoias",
            "Total consultorias",
            "Total transfeerncias",
            "Total calibraciones",
            "Total servicios",
            "Total ejecucion del centro con total recurso asignado",
            "Total ejecucion del centro con recurso vigente",
        ];

        $excel->getActiveSheet()
            ->fromArray(
                $cabeceras,
                NULL,
                'A1'
            )->getRowDimension('1') //primera columna
            ->setRowHeight(50); //altura de 50

        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 11,
                'name'  => 'Segoe UI'
            ),
            'borders' => array(
                'outline' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => array('rgb' => '64DC77'),
                ),
            ),
            'alignment' => array(
                'horizontal' => 'left',
                'vertical' => 'top',
                'wrapText' => true,
            ),
            'fill' => array(
                'fillType' => 'solid',
                'startColor' => array('rgb' => 'FF6B00'),
            ),
        );
        $excel->getActiveSheet()->getStyle('A1:CJ1')->applyFromArray($styleArray); //estilos de la cabecera
        $excel->getActiveSheet()->setAutoFilter('A1:CJ1'); //filtrado automatizado

        /* Cabecera */
        $hojaActiva->getStyle('BU')
            ->getNumberFormat()
            ->setFormatCode('"$"_###,##0');
        $hojaActiva->getStyle('BV')
            ->getNumberFormat()
            ->setFormatCode('"$"_###,##0');
        $hojaActiva->getStyle('BW')
            ->getNumberFormat()
            ->setFormatCode('"$"_###,##0');
        $hojaActiva->getStyle('CB')
            ->getNumberFormat()
            ->setFormatCode('"%"###,##0');
        $hojaActiva->getStyle('CC')
            ->getNumberFormat()
            ->setFormatCode('"%"###,##0');

        if (count($sistemaGestion)) {
            $excel->getActiveSheet()
                ->fromArray(
                    $sistemaGestion,
                    NULL,
                    'A2'
                );
        } else {
            $excel->getActiveSheet()->setCellValue('A2', '🚧 Lo sentimos, pero aún no se han registrado datos ❌');
        }

        /* Valores  totales*/

        /* $totalServicios = 0; */
        $repeticiones = count($sistemaGestion);
        if ($repeticiones) {
            $repeticiones += 1; // se suma una celda para empezar despues del titulo o encabezado.
            for ($iterador = 2; $iterador <= $repeticiones; $iterador++) {
                foreach ($sistemaGestion as $pregunta) {
                    /* $totalServicios++; */
                    $hojaActiva->setCellValue('CB' . $iterador, "=AS{$iterador} / AR{$iterador} * 100"); //Meta apendices atendidos
                    $hojaActiva->setCellValue('CC' . $iterador, "=AG{$iterador} / AH{$iterador} * 100"); //Meta empresas atendidas

                    /* Total asesorias =SUMA(AA2;AH2;AJ2;AS2;AU2;BE2) */
                    $hojaActiva->setCellValue(
                        'CD' . $iterador,
                        "=SUM(AA{$iterador},AH{$iterador},AJ{$iterador},AS{$iterador},AU{$iterador},BE{$iterador})"
                    );
                    /* Total consultorias =SUMA(AC2;AL2;BG2) */
                    $hojaActiva->setCellValue(
                        'CE' . $iterador,
                        "=SUM(AC{$iterador},AL{$iterador},BG{$iterador})"
                    );
                    /* Total transferencias */
                    $hojaActiva->setCellValue(
                        'CF' . $iterador,
                        "=SUM(AN{$iterador},AY{$iterador})"
                    );
                    /* Total calibraciones */
                    $hojaActiva->setCellValue(
                        'CG' . $iterador,
                        "=SUM(AE{$iterador},AP{$iterador},BA{$iterador},BI{$iterador})"
                    );
                    /* Total servicios */
                    $hojaActiva->setCellValue(
                        'CH' . $iterador,
                        count($sistemaGestion)
                    );
                }
                /* TODO: INVESTIGAR LOS VALORES
                **Total ejecucion del centro con total recurso asignado
                **Total ejecucion del centro con recurso vigente
                Para asi hacer las formulas pertinentes para esas columnas o celdas.
                */
            }
            /* Valores  totales de celdas*/
        }

        $cellIterator = $hojaActiva->getRowIterator()->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true);
        /** @var PHPExcel_Cell $cell */
        foreach ($cellIterator as $cell) {
            $hojaActiva->getColumnDimension($cell->getColumn())->setAutoSize(true);
        }

        $writer = new Xlsx($excel);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment');
        $writer->save('php://output');

        exit(); //Cierra el documento para luego abrirlo sin problemas.
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $SistemaGestion = SistemaGestion::create($request->all());
        return (new SistemaGestionResource($SistemaGestion))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}
