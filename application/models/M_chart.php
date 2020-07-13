<?php    
class M_chart extends CI_Model{

    // Query u/ menampilkan grafik cost dari seluruh PM hari ini
    function cost_chart(){
        $query = $this->db->query("SELECT concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE DATE(updated_date_hour) = CURDATE()
                                   GROUP BY updated_hour");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan grafik cost dari 1 PM/jam dalam 1 hari
    function cost_chart_filter_tanggal($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
                                   // COLLATE utf8mb4_unicode_ci 
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan grafik cost dari 1 PM dalam 1 bulan
    function cost_chart_filter_bulan($device, $bulan, $tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          updated_date_hour as tanggal,
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'
                                   GROUP BY updated_date_hour");
                                   //COLLATE utf8mb4_unicode_ci 
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // QUERY PER BULAN ALTERNATE
    // function cost_chart_filter_bulan($bulan, $tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(bill_r_hour) as cost_r,
    //                                       sum(bill_s_hour) as cost_s,
    //                                       sum(bill_t_hour) as cost_t
    //                                FROM billing_hour
    //                                WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
    //                                GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
    //     if($query->num_rows() > 0){
    //         foreach($query->result() as $data){
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }

    // Query u/ menampilkan total cost pada grafik cost
    function cost_chart_total(){
        $query = $this->db->query("SELECT concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE DATE(updated_date_hour) = CURDATE()
                                   ");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan total cost per tanggal dari 1 PM pada grafik cost
    function cost_chart_filter_tanggal_total($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                    FROM billing_hour
                                    WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan total cost per bulan dari 1 PM pada grafik cost
    function cost_chart_filter_bulan_total($device, $bulan, $tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    //QUERY TOTAL PER BULAN ALTERNATE
    //  function cost_chart_filter_bulan_total($bulan, $tahun){
    //      $query = $this->db->query("SELECT monthname(updated_date_hour) as bln, 
    //                                        sum(bill_r_hour) as cost_r,       
    //                                        sum(bill_s_hour) as cost_s,       
    //                                        sum(bill_t_hour) as cost_t
    //                                 FROM billing_hour
    //                                 WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
    //      if($query->num_rows() > 0){
    //          foreach($query->result() as $data){
    //              $hasil[] = $data;
    //          }
    //          return $hasil;
    //      }
    //  }

    // ==============================================================================================================

    // Query u/ menampilkan grafik kwh dari seluruh PM hari ini
    function kwh_chart(){
        $query = $this->db->query("SELECT concat(updated_hour,':','00') as jam, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t 
                                   FROM billing_hour
                                   WHERE DATE(updated_date_hour) = CURDATE() 
                                   GROUP BY updated_hour");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan grafik kwh per tanggal dari 1 PM/jam dalam 1 hari
    function kwh_chart_filter_tanggal($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
                                   //COLLATE utf8mb4_unicode_ci
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan grafik kwh per bulan dari 1 PM 
    function kwh_chart_filter_bulan($device, $bulan, $tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          updated_date_hour as tanggal,
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'
                                   GROUP BY updated_date_hour");
                                   //COLLATE utf8mb4_unicode_ci
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // QUERY PER BULAN ALTERNATE
    // function kwh_chart_filter_bulan($bulan, $tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(kwh_r) as kwh_r,
    //                                       sum(kwh_s) as kwh_s,
    //                                       sum(kwh_t) as kwh_t
    //                                FROM billing_hour
    //                                WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
    //                                GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
    //     if($query->num_rows() > 0){
    //         foreach($query->result() as $data){
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }

    // Query u/ menampilkan total kwh pada grafik kwh
    function kwh_chart_total(){
        $query = $this->db->query("SELECT concat(updated_hour,':','00') as jam, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE DATE(updated_date_hour) = CURDATE()
                                   ");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan total kwh per tanggal dari 1 PM pada grafik kwh
    function kwh_chart_filter_tanggal_total($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                    FROM billing_hour
                                    WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // Query u/ menampilkan total kwh per bulan dari 1 PM pada grafik kwh
    function kwh_chart_filter_bulan_total($device, $bulan, $tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                           sum(kwh_r) as kwh_r,       
                                           sum(kwh_s) as kwh_s,       
                                           sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    // QUERY TOTAL PER BULAN ALTERNATE
    // function kwh_chart_filter_bulan_total($bulan, $tahun){
    //     $query = $this->db->query("SELECT monthname(updated_date_hour) as bln, 
    //                                       sum(kwh_r) as kwh_r,       
    //                                       sum(kwh_s) as kwh_s,       
    //                                       sum(kwh_t) as kwh_t
    //                                FROM billing_hour
    //                                WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
    //     if($query->num_rows() > 0){
    //         foreach($query->result() as $data){
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }

    public function ExportExcelIndex(){
        $query = $this->db->query("SELECT concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE DATE(updated_date_hour) = CURDATE()
                                   GROUP BY updated_hour");
        return $query->result();
    }

    // Export grafik cost per tanggal
    public function ExportExcelTanggal($device,$tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          updated_date_hour as periode,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
                                   //COLLATE utf8mb4_unicode_ci
  		return $query->result();
    }

    // Export grafik cost per bulan
    public function ExportExcelBulan($device, $bulan,$tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          monthname(updated_date_hour) as bln,
                                          year(updated_date_hour) as thn,
                                          updated_date_hour as tanggal,
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'
                                   GROUP BY updated_date_hour");
  		return $query->result();
    }

    // EXPORT COST BULAN
    // public function ExportExcelBulan($bulan,$tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(bill_r_hour) as cost_r,
    //                                       sum(bill_s_hour) as cost_s,
    //                                       sum(bill_t_hour) as cost_t,
    //                                       sum(bill_r_hour)+sum(bill_s_hour)+sum(bill_t_hour) as total
    //                                FROM billing_hour
    //                                WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
    //                                GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
  	// 	return $query->result();
    // }

    // Export grafik kwh per tanggal
    public function kwh_ExportExcelTanggal($device,$tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          updated_date_hour as periode,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
  		return $query->result();
    }

    // Export grafik kwh per bulan
    public function kwh_ExportExcelBulan($device, $bulan,$tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          dev_loc as loc,
                                          monthname(updated_date_hour) as bln,
                                          year(updated_date_hour) as thn,
                                          updated_date_hour as tanggal,
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   JOIN devices ON dev_bill_hour = dev
                                   WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'
                                   GROUP BY updated_date_hour");
  		return $query->result();
    }

    // EXPORT KWH BULAN
    // public function kwh_ExportExcelBulan($bulan,$tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(kwh_r) as kwh_r,
    //                                       sum(kwh_s) as kwh_s,
    //                                       sum(kwh_t) as kwh_t,
    //                                       sum(kwh_r)+sum(bill_s_hour)+sum(bill_t_hour) as total
    //                                FROM billing_hour
    //                                WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
    //                                GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
  	// 	return $query->result();
    // }
}