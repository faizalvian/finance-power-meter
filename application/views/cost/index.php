<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
      .vertical-center {
          margin-top: 10%;
      }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Grafik Cost</title>
  </head>
  <body>
    <div class="container vertical-center">
      <div class="card">
        <div class="card-body">
          <div class="col">
            <!--?php echo "<b>Tanggal : </b>" . date('d/M/Y') . ""; ?-->
          </div>
          <div class="container d-flex h-100 flex-column">
            <div class="flex-grow-1"></div>
            <div class="row justify-content-center">
              <div class="col text-center mt-2">
                <img class="mb-3" src="https://demo.pm-meter.com/assets/img/ALI-60051.png" style="height:128px; width:128px" alt=""><br> 
                <b>Lihat Data Berdasarkan : </b>
                <div class="dropdown d-inline">
                  <select name="options" id="options">
                    <option value=""> -- Pilih --</option>
                    <option value="1"> Hari</option>
                    <option value="2"> Bulan</option>
                  </select>
              
                  <div class="container">
                    <!-- Form filter tanggal -->
                    <form action="<?php echo base_url('cost/perTanggal') ?>" method="GET" class="mt-2" id="1" style="display:none">
                      <div class="input-group mb-3">
                        <select name="device" class="form-control">
                        <?php 
                          foreach($device as $row)
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

                    <!-- Form filter bulan -->
                    <form action="<?php echo base_url('cost/perBulan') ?>" method="GET" class="mt-2" id="2" style="display:none">
                      <div class="input-group mb-3">
                        <select name="device" class="form-control">
                          <?php 
                            foreach($device as $row)
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
                          echo "<select name='tahun' class='form-control' name='tahun' id='tahun'>";
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
            </div>
          </div>
          <div class="flex-grow-1"></div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

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