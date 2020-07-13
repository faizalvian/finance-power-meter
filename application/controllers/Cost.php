<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
class Cost extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('m_chart');
        $this->load->model('m_device');
        $this->load->helper('url');
    }

    // Menampilkan halaman index cost
    public function index()
    {
        $data['cost'] = $this->m_chart->cost_chart();
        $data['device'] = $this->m_device->getAllDevices();
        $data['cost_total'] = $this->m_chart->cost_chart_total();
        $this->load->view('cost/index', $data);
    }

    // Filter cost berdasarkan tanggal/hari
    public function perTanggal()
    {
        $device  = $this->input->get('device');
		$tanggal  = $this->input->get('tanggal');
        $getGrafik = $this->m_chart->cost_chart_filter_tanggal($device, $tanggal);
        $getTotal = $this->m_chart->cost_chart_filter_tanggal_total($device, $tanggal);
        
        $data = [
            'getGrafik' => $getGrafik,
            'getTotal' => $getTotal,
            'device' => $device,
            'tanggal' => $tanggal
        ];
        $data['dev'] = $this->m_device->getAllDevices();
        $this->load->view('cost/tanggal', $data);
    }

    // Filter cost berdasarkan bulan
    public function perBulan()
    {
        $device  = $this->input->get('device');
		$bulan  = $this->input->get('bulan');
		$tahun  = $this->input->get('tahun');
    	$getGrafik = $this->m_chart->cost_chart_filter_bulan($device, $bulan, $tahun);
        //$getGrafik = $this->m_chart->cost_chart_filter_bulan($bulan, $tahun);
        $getTotal = $this->m_chart->cost_chart_filter_bulan_total($device, $bulan, $tahun);
        
        $data = [
            'getGrafik' => $getGrafik,
            'getTotal' => $getTotal,
            'device' => $device,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        $data['dev'] = $this->m_device->getAllDevices();
        $this->load->view('cost/bulan', $data);
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Export grafik di halaman index
    public function ExcelIndex()
    {
        $this->load->model('m_chart');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Jam');
        $sheet->setCellValue('C1', 'Cost R');
        $sheet->setCellValue('D1', 'Cost S');
        $sheet->setCellValue('E1', 'Cost T');
    
        $cost = $this->m_chart->ExportExcelIndex();
        $no = 1;
        $x = 2;
        foreach($cost as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->jam);
            $sheet->setCellValue('C'.$x, number_format($row->cost_r,2,',','.'));
            $sheet->setCellValue('D'.$x, number_format($row->cost_s,2,',','.'));
            $sheet->setCellValue('E'.$x, number_format($row->cost_t,2,',','.'));
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename ='Cost_all_PM -' . $tanggal . '';
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // Export grafik berdasarkan filter tanggal
    public function ExcelTanggal($device,$tanggal)
    {
        $this->load->model('m_chart');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $cost = $this->m_chart->ExportExcelTanggal($device, $tanggal);
        $no = 1;
        $x = 5;
        foreach($cost as $row)
        {
            // Heading Sensor Name
            $sheet->setCellValue('A1', $row->pm ." - ". $row->loc);
            $sheet->mergeCells("A1:E1");
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true);

            // Heading Date
            $sheet->setCellValue('A2', "Tanggal : ".date("d/M/Y", strtotime($row->periode)));
            $sheet->mergeCells("A2:E2");
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setBold(true);

            // Heading Total Cost
            $total = $this->m_chart->cost_chart_filter_tanggal_total($device, $tanggal);

            // Set width column
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);

            //Foreach for get total cost
            foreach($total as $row2){
                $sheet->setCellValue('A3', "Total : Rp. ".number_format($row2->cost_r+$row2->cost_s+$row2->cost_t,2,',','.'));
                $sheet->mergeCells("A3:E3");
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A3')->getFont()->setBold(true);
            }

            // Table heading
            $sheet->setCellValue('A4', "No");
            $sheet->setCellValue('B4', "Jam");
            $sheet->setCellValue('C4', "Cost R");
            $sheet->setCellValue('D4', "Cost S");
            $sheet->setCellValue('E4', "Cost T");
            $sheet->getStyle('A4:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:E4')->getFont()->setBold(true);

            // Table row
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->jam);
            $sheet->setCellValue('C'.$x, number_format($row->cost_r,2,',','.'));
            $sheet->setCellValue('D'.$x, number_format($row->cost_s,2,',','.'));
            $sheet->setCellValue('E'.$x, number_format($row->cost_t,2,',','.'));
            $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        // Excel file name
        $filename ='Cost - ' . $device . '-' . $tanggal . '';
        // Worksheet name
        $spreadsheet->getActiveSheet()->setTitle($device.' - '.$tanggal);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // Export grafik berdasarkan filter bulan
    public function ExcelBulan($device,$bulan,$tahun)
    {
        $this->load->model('m_chart');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $cost = $this->m_chart->ExportExcelBulan($device, $bulan, $tahun);
        $no = 1;
        $x = 5;
        foreach($cost as $row)
        {
            // Heading Sensor Name
            $sheet->setCellValue('A1', $row->pm ." - ". $row->loc);
            $sheet->mergeCells("A1:E1");
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A1')->getFont()->setBold(true);

            // Heading Date
            $sheet->setCellValue('A2', "Bulan : ".$row->bln. " " .$row->thn);
            $sheet->mergeCells("A2:E2");
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A2')->getFont()->setBold(true);

            // Set width column
            $sheet->getColumnDimension('B')->setWidth(20);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(20);

            // Heading Total Cost
            $total = $this->m_chart->cost_chart_filter_bulan_total($device, $bulan, $tahun);

            //Foreach for get total cost
            foreach($total as $row2){
                $sheet->setCellValue('A3', "Total : Rp. ".number_format($row2->cost_r+$row2->cost_s+$row2->cost_t,2,',','.'));
                $sheet->mergeCells("A3:E3");
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A3')->getFont()->setBold(true);
            }

            // Table heading
            $sheet->setCellValue('A4', "No");
            $sheet->setCellValue('B4', "Tanggal");
            $sheet->setCellValue('C4', "Cost R");
            $sheet->setCellValue('D4', "Cost S");
            $sheet->setCellValue('E4', "Cost T");
            $sheet->getStyle('A4:E4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A4:E4')->getFont()->setBold(true);

            // Table row
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, date("d-m-Y", strtotime($row->tanggal)));
            $sheet->setCellValue('C'.$x, number_format($row->cost_r,2,',','.'));
            $sheet->setCellValue('D'.$x, number_format($row->cost_s,2,',','.'));
            $sheet->setCellValue('E'.$x, number_format($row->cost_t,2,',','.'));
            $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        // Excel file name
        $filename ='Cost - ' . $device . '-' . $bulan . '';
        // Worksheet name
        $spreadsheet->getActiveSheet()->setTitle($device.' - '.$bulan.' '.$tahun);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // FUNCTION PER BULAN ALTERNATE
    // public function perBulan()
    // {
    //     $device  = $this->input->get('device');
	// 	$bulan  = $this->input->get('bulan');
	// 	$tahun  = $this->input->get('tahun');
    // 	//$getGrafik = $this->m_chart->cost_chart_filter_bulan($device, $bulan, $tahun);
    //     $getGrafik = $this->m_chart->cost_chart_filter_bulan($bulan, $tahun);
    //     $getTotal = $this->m_chart->cost_chart_filter_bulan_total($bulan, $tahun);
        
    //     $data = [
    //         'getGrafik' => $getGrafik,
    //         'getTotal' => $getTotal,
    //         'device' => $device,
    //         'bulan' => $bulan,
    //         'tahun' => $tahun
    //     ];
    //     $data['dev'] = $this->m_device->getAllDevices();
       
    //     $this->load->view('cost/bulan', $data);
    // }

    //FUNCTION EXPORT ALTERNATE
    // public function ExcelBulan($bulan,$tahun)
    // {
    //     $this->load->model('m_chart');
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'Device');
    //     $sheet->setCellValue('C1', 'Cost R');
    //     $sheet->setCellValue('D1', 'Cost S');
    //     $sheet->setCellValue('E1', 'Cost T');
    
    //     $cost = $this->m_chart->ExportExcelBulan($bulan, $tahun);
    //     $no = 1;
    //     $x = 2;
    //     foreach($cost as $row)
    //     {
    //         $sheet->setCellValue('A'.$x, $no++);
    //         $sheet->setCellValue('B'.$x, $row->pm);
    //         $sheet->setCellValue('C'.$x, number_format($row->cost_r,2,',','.'));
    //         $sheet->setCellValue('D'.$x, number_format($row->cost_s,2,',','.'));
    //         $sheet->setCellValue('E'.$x, number_format($row->cost_t,2,',','.'));
    //         $x++;
    //     }
    //     $writer = new Xlsx($spreadsheet);
    //     $filename ='Cost - ' . $bulan . '-' . $tahun . '';
    
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
}