<?php    
class M_chart extends CI_Model{

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

    function cost_chart_filter_tanggal($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

     function cost_chart_filter_bulan($bulan, $tahun){
         $query = $this->db->query("SELECT dev_bill_hour as pm,
                                           monthname(updated_date_hour) as bln,
                                           year(updated_date_hour) as tahun,
                                           sum(bill_r_hour) as cost_r,
                                           sum(bill_s_hour) as cost_s,
                                           sum(bill_t_hour) as cost_t
                                    FROM billing_hour
                                    WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
                                    GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
         if($query->num_rows() > 0){
             foreach($query->result() as $data){
                 $hasil[] = $data;
             }
             return $hasil;
         }
     }

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

    // function cost_chart_filter_bulan_total($device, $bulan, $tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       updated_date_hour as tanggal,
    //                                       sum(bill_r_hour) as cost_r,       
    //                                       sum(bill_s_hour) as cost_s,       
    //                                       sum(bill_t_hour) as cost_t
    //                                FROM billing_hour
    //                                WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year('updated_date_hour') = '$tahun'");
    //     if($query->num_rows() > 0){
    //         foreach($query->result() as $data){
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }

     function cost_chart_filter_bulan_total($bulan, $tahun){
         $query = $this->db->query("SELECT monthname(updated_date_hour) as bln, 
                                           sum(bill_r_hour) as cost_r,       
                                           sum(bill_s_hour) as cost_s,       
                                           sum(bill_t_hour) as cost_t
                                    FROM billing_hour
                                    WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
         if($query->num_rows() > 0){
             foreach($query->result() as $data){
                 $hasil[] = $data;
             }
             return $hasil;
         }
     }

    // function cost_chart_filter_bulan($device, $bulan, $tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(bill_r_hour) as cost_r,       
    //                                       sum(bill_s_hour) as cost_s,       
    //                                       sum(bill_t_hour) as cost_t
    //                                FROM billing_hour
    //                                WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
    //                                GROUP BY monthname(updated_date_hour), year(updated_date_hour)");
    //     if($query->num_rows() > 0){
    //         foreach($query->result() as $data){
    //             $hasil[] = $data;
    //         }
    //         return $hasil;
    //     }
    // }


    // ==============================================================================================================

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

    function kwh_chart_filter_tanggal($device, $tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          sum(kwh_r) as kwh_r,       
                                          concat(updated_hour,':','00') as jam, 
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function kwh_chart_filter_bulan($bulan, $tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          monthname(updated_date_hour) as bln,
                                          year(updated_date_hour) as tahun,
                                          sum(kwh_r) as kwh_r,
                                          sum(kwh_s) as kwh_s,
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
                                   GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

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

    function kwh_chart_filter_bulan_total($bulan, $tahun){
        $query = $this->db->query("SELECT monthname(updated_date_hour) as bln, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun'");
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


    

    // function kwh_chart_filter_bulan($device, $bulan, $tahun){
    //     $query = $this->db->query("SELECT dev_bill_hour as pm,
    //                                       monthname(updated_date_hour) as bln,
    //                                       year(updated_date_hour) as tahun,
    //                                       sum(kwh_r) as kwh_r,       
    //                                       sum(kwh_s) as kwh_s,       
    //                                       sum(kwh_t) as kwh_t
    //                                FROM billing_hour
    //                                WHERE dev_bill_hour = '$device' AND monthname(updated_date_hour) = '$bulan' and year(updated_date_hour) = '$tahun' 
    //                                GROUP BY monthname(updated_date_hour), year(updated_date_hour)");
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

    public function ExportExcelTanggal($device,$tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(bill_r_hour) as cost_r,       
                                          sum(bill_s_hour) as cost_s,       
                                          sum(bill_t_hour) as cost_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
  		return $query->result();
    }

    public function ExportExcelBulan($bulan,$tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          monthname(updated_date_hour) as bln,
                                          year(updated_date_hour) as tahun,
                                          sum(bill_r_hour) as cost_r,
                                          sum(bill_s_hour) as cost_s,
                                          sum(bill_t_hour) as cost_t,
                                          sum(bill_r_hour)+sum(bill_s_hour)+sum(bill_t_hour) as total
                                   FROM billing_hour
                                   WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
                                   GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
  		return $query->result();
    }

    public function kwh_ExportExcelTanggal($device,$tanggal){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          concat(updated_hour,':','00') as jam, 
                                          sum(kwh_r) as kwh_r,       
                                          sum(kwh_s) as kwh_s,       
                                          sum(kwh_t) as kwh_t
                                   FROM billing_hour
                                   WHERE dev_bill_hour = '$device' AND DATE(updated_date_hour) = '$tanggal'
                                   GROUP BY updated_hour");
  		return $query->result();
    }

    public function kwh_ExportExcelBulan($bulan,$tahun){
        $query = $this->db->query("SELECT dev_bill_hour as pm,
                                          monthname(updated_date_hour) as bln,
                                          year(updated_date_hour) as tahun,
                                          sum(kwh_r) as kwh_r,
                                          sum(kwh_s) as kwh_s,
                                          sum(kwh_t) as kwh_t,
                                          sum(kwh_r)+sum(bill_s_hour)+sum(bill_t_hour) as total
                                   FROM billing_hour
                                   WHERE monthname(updated_date_hour) = '$bulan' AND year(updated_date_hour) = '$tahun' 
                                   GROUP BY dev_bill_hour, monthname(updated_date_hour), year(updated_date_hour)");
  		return $query->result();
    }
}