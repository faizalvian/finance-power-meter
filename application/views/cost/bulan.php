<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        .vertical-center {
            margin-top: 10%;
        }
    </style>

    <title>Grafik Cost</title>
  </head>
  <body>
    <div class="container vertical-center">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <?php echo "<b>Periode : </b>".$_GET['bulan']. "/" .$_GET['tahun']; ?><br>
              <?php echo "<b>Device : </b>" . $_GET['device'] . ""; ?>
            </div>
            <div class="col" style="margin-left:25%"> 
              <b>Lihat Data Berdasarkan : </b>
              <div class="dropdown d-inline">
                <select name="options" id="options">
                  <option value=""> -- Pilih --</option>
                  <option value="1"> Hari</option>
                  <option value="2"> Bulan</option>
                </select>

                <!-- Form filter berdasarkan hari/tanggal -->
                <form action="<?php echo base_url('cost/perTanggal') ?>" method="GET" class="mt-2" id="1" style="display:none">
                  <div class="input-group mb-3">
                    <select name="device" class="form-control">
                      <?php 
                        foreach($dev as $row)
                        { 
                          echo '<option value="'.$row->dev.'">'.$row->dev. ' - ' .$row->dev_loc.'</option>';
                        }
                      ?>
                    </select>
                    <input type="date" class="form-control" name="tanggal">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary">Cari <i class="fas fa-luv"></i></button>
                    </div>
                  </div>
                </form>
                
                <!-- Form filter berdasarkan bulan -->
                <form action="<?php echo base_url('cost/perBulan') ?>" method="GET" class="mt-2" id="2" style="display:none">
                  <div class="input-group mb-3">
                    <select name="device" class="form-control">
                      <?php 
                        foreach($dev as $row)
                        { 
                          echo '<option value="'.$row->dev.'">'.$row->dev. ' - ' .$row->dev_loc.'</option>';
                        }
                      ?>
                    </select>
                    <select name="bulan" class="form-control">
                    <?php
                      $bulan=array("January","February","March","April","May","June","July","August","September","October","November","December");
                      $jum_bln=count($bulan);
                      for($c=0; $c<$jum_bln; $c+=1){
                          echo"<option value=$bulan[$c]> $bulan[$c] </option>";
                      }
                    ?>
                    </select> 
                    <?php
                      $now=date('Y');
                      echo "<select name='tahun' class='form-control'>";
                      for ($a=2019;$a<=$now;$a++){
                          echo "<option value='$a'>$a</option>";
                      }
                      echo "</select>";
                    ?>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary">Cari <i class="fas fa-luv"></i></button>
                    </div>
                  </div>
                </form>
                
              </div>
            </div>
          </div>
          <?php if(isset($_GET['bulan'], $_GET['tahun'])){?>
            <?php if($getGrafik != null) { ?>
              <?php
                foreach($getGrafik as $result){
                  $dev = $result->pm;
                  $location = $result->loc;
                  $tanggal[] = $result->tanggal; 
                  $value1[] = (integer) $result->cost_r; 
                  $value2[] = (integer) $result->cost_s;
                  $value3[] = (integer) $result->cost_t;
                }
                foreach($getTotal as $result){ 
                  $total_r = $result->cost_r; 
                  $total_s = $result->cost_s;
                  $total_t = $result->cost_t;
                }
                if ($getGrafik > 0) {
                  echo '
                  <div style="margin-top:3%">
                    <h5 class="text-center">' .$dev. ' - '.$location.'</h5>
                    <h5 class="text-center" style="color:#666666">Total biaya : Rp. ' . number_format($total_r + $total_s + $total_t,2,',','.') .'</h5>
                    <div class="text-center">
                      <small class="d-inline" style="color:#FF6384"><b>Cost R : </b></small> <small><b>Rp. ' . number_format($total_r,2,',','.') .'</b></small>
                      &nbsp;&nbsp;&nbsp;
                      <small class="d-inline" style="color:#FFCD56"><b>Cost S : </b></small> <small><b>Rp. ' . number_format($total_s,2,',','.') .'</b></small>
                      &nbsp;&nbsp;&nbsp;
                      <small class="d-inline" style="color:#36A2EB"><b>Cost T : </b></small> <small><b>Rp. ' . number_format($total_t,2,',','.') .'</b></small><br>  
                    </div>
                    <div id="report"></div>
                    <div class="col mt-1 text-center">
                      <a href="'. site_url('cost/excelbulan/'.$_GET['device'].'/'.$_GET['bulan'].'/'.$_GET['tahun'].'/') .'" class="btn btn-success btn-sm">Download Excel</a>
                    </div>
                  </div>';
                }else{
                  echo "
                  <center>
                    <div style='margin-top:100px'>
                      <img src='https://img.icons8.com/flat_round/64/000000/error--v1.png'/>
                      <h5 class='mt-3'>Data tidak ditemukan</h5>
                    </div>
                  </center>";
                }   
              ?>
            <?php } else { ?>
              <center>
                <div style='margin-top:100px'>
                  <img src='https://img.icons8.com/flat_round/64/000000/error--v1.png'/>
                  <h5 class='mt-3'>Data tidak ditemukan</h5>
                </div>
              </center>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/export-data.js"></script>

    <!-- Highcharts -->
    <script type="text/javascript">
      $(function () {
          $('#report').highcharts({
              chart: {
              type: 'column'
          },
          title: {
              text: ''
          },
          subtitle: {
              text: ''
          },
          xAxis: {
              categories:  <?php echo json_encode($tanggal);?>
          },
          yAxis: {
              min: 0,
              title: {
                  text: 'Rupiah (Rp.)'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>Rp. {point.y:.1f}</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
                  name: 'Cost R',
                  data: <?php echo json_encode($value1);?>,
                  color: '#ff6384'
              },{
                  name: 'Cost S',
                  data: <?php echo json_encode($value2);?>,
                  color: '#ffcd56'
              },{
                  name: 'Cost T',
                  data: <?php echo json_encode($value3);?>,
                  color: '#36a2eb'
              }]
          });
      });
    </script>

    <!-- Show filter -->
    <script>
      document.getElementById('options').onchange = function() {
          var i = 1;
          var myDiv = document.getElementById(i);
          while(myDiv) {
              myDiv.style.display = 'none';
              myDiv = document.getElementById(++i);
          }
          document.getElementById(this.value).style.display = 'block';
      };
    </script>

  </body>
</html>