<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
 
class Kwh extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('m_chart');
        $this->load->model('m_device');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['kwh'] = $this->m_chart->kwh_chart();
        $data['dev'] = $this->m_device->getAllDevices();
        $data['kwh_total'] = $this->m_chart->kwh_chart_total();
        $this->load->view('kwh/index', $data);
    }

    public function perTanggal()
    {
        $device  = $this->input->get('device');
		$tanggal  = $this->input->get('tanggal');
        $getGrafik = $this->m_chart->kwh_chart_filter_tanggal($device, $tanggal);
        $getTotal = $this->m_chart->kwh_chart_filter_tanggal_total($device, $tanggal);
        
        $data = [
            'getGrafik' => $getGrafik,
            'getTotal' => $getTotal,
            'device' => $device,
            'tanggal' => $tanggal
        ];
        $data['dev'] = $this->m_device->getAllDevices();
       
        $this->load->view('kwh/tanggal', $data);
    }

    public function perBulan()
    {
		$device  = $this->input->get('device');
		$bulan  = $this->input->get('bulan');
		$tahun  = $this->input->get('tahun');
    	//$getGrafik = $this->m_chart->cost_chart_filter_bulan($device, $bulan, $tahun);
        $getGrafik = $this->m_chart->kwh_chart_filter_bulan($bulan, $tahun);
        $getTotal = $this->m_chart->kwh_chart_filter_bulan_total($bulan, $tahun);
        
        $data = [
            'getGrafik' => $getGrafik,
            'getTotal' => $getTotal,
            'bulan' => $bulan,
            'tahun' => $tahun
        ];
        $data['dev'] = $this->m_device->getAllDevices();
       
        $this->load->view('kwh/bulan', $data);
    }

    public function ExcelTanggal($device,$tanggal)
    {
        $this->load->model('m_chart');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Jam');
        $sheet->setCellValue('C1', 'Cost R');
        $sheet->setCellValue('D1', 'Cost S');
        $sheet->setCellValue('E1', 'Cost T');
    
        $cost = $this->m_chart->kwh_ExportExcelTanggal($device, $tanggal);
        $no = 1;
        $x = 2;
        foreach($cost as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->jam);
            $sheet->setCellValue('C'.$x, $row->kwh_r);
            $sheet->setCellValue('D'.$x, $row->kwh_s);
            $sheet->setCellValue('E'.$x, $row->kwh_t);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename ='Kwh - ' . $device . '-' . $tanggal . '';
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function ExcelBulan($bulan,$tahun)
    {
        $this->load->model('m_chart');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Device');
        $sheet->setCellValue('C1', 'Cost R');
        $sheet->setCellValue('D1', 'Cost S');
        $sheet->setCellValue('E1', 'Cost T');
    
        $cost = $this->m_chart->kwh_ExportExcelBulan($bulan, $tahun);
        $no = 1;
        $x = 2;
        foreach($cost as $row)
        {
            $sheet->setCellValue('A'.$x, $no++);
            $sheet->setCellValue('B'.$x, $row->pm);
            $sheet->setCellValue('C'.$x, $row->kwh_r);
            $sheet->setCellValue('D'.$x, $row->kwh_s);
            $sheet->setCellValue('E'.$x, $row->kwh_t);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename ='kWh - ' . $bulan . '-' . $tahun . '';
    
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}