<?php
    function helper_hari($param){

        $date = new DateTime($param);
        $key = $date->format('l');

        $arr = array(
            "Sunday" => "Minggu",
            "Monday" => "Senin",
            "Tuesday" => "Selasa",
            "Wednesday" => "Rabu",
            "Thursday" => "Kamis",
            "Friday" => "Jumat",
            "Saturday" => "Sabtu",
        );

        return $arr[$key];
        
    }

    function helper_bulan($param){

        $date = new DateTime($param);
        $key = $date->format('m');

        $arr = array(
            "1" => "Januari",
            "2" => "Februari",
            "3" => "Maret",
            "4" => "April",
            "5" => "Mei",
            "6" => "Juni",
            "7" => "Juli",
            "8" => "Agustu",
            "9" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember",
        );

        return $arr[$key];
        
    }

    function get_session(){
        
        include 'config.php';

        $sql = "SELECT `session` FROM session_now WHERE id = '1'";
        // echo $sql;
        $result = $conn->query($sql);

        $sess_now = "";
        if($result->num_rows == 0){ //tidak ada record
            //buat dulu / create dulu / insert dulu
            if(create_session() === true){
                //get ulang
                $sql_1 = "SELECT `session` FROM session_now WHERE id = '1'";
                $result_1 = $conn->query($sql_1);

                while ($rows_1 = $result_1->fetch_assoc()) {

                    if($rows_1['session'] === null){

                        if(update_session() === true){
                            //get ulang sa nggs d update
                            $sql_2 = "SELECT `session` FROM session_now WHERE id = '1'";
                            $result_2 = $conn->query($sql_2);

                            while ($rows_2 = $result_2->fetch_assoc()) {
                                $sess_now = $rows_2['session'];
                            }

                        }else{

                            return 'Gagal Update Session !';

                        }

                    }else{
                        $sess_now = $rows_1['session'];
                    }
            
                }

            }else{
                return 'Gagal Insert Session !';
            }

        }else{

            while ($rows = $result->fetch_assoc()) {

                if($rows['session'] === null){

                    if(update_session() === true){
                        //get ulang sa nggs d update
                        $sql_2 = "SELECT `session` FROM session_now WHERE id = '1'";
                        $result_2 = $conn->query($sql_2);

                        while ($rows_2 = $result_2->fetch_assoc()) {
                            $sess_now = $rows_2['session'];
                        }

                    }else{

                        return 'Gagal Update Session !';

                    }

                }else{
                    $sess_now = $rows['session'];
                }
                
            }

        }

        return $sess_now;
        

    }

    function create_session(){

        include 'config.php';

        $new_sess = base64_encode('create_session'.date("YmdHis"));

        $sql = "INSERT INTO `session_now` (`session`) VALUES('{$new_sess}')";
        // $result = $conn->query($sql);

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            // throw new Exception("Error: " . $sql . "<br>" . $conn->error);
            return false;
        }
    }

    function update_session(){

        include 'config.php';

        $new_sess = base64_encode('update_session'.date("YmdHis"));

        $sql = "UPDATE session_now SET `session` = '{$new_sess}' WHERE id = '1' ";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            // throw new Exception("Error: " . $sql . "<br>" . $conn->error);
            return false;
        }
    }

    function destroy_session(){

        include 'config.php';

        //ambil data session sekarang
        $sql_1 = "SELECT session FROM session_now WHERE id = '1' ";
        $result_1 = $conn->query($sql_1);

        $sess_now = "";
        while ($rows_1 = $result_1->fetch_assoc()) {
            $sess_now = $rows_1['session'];
        }

        //replace ke table session_old
        if($sess_now !== null){
            $sql_2 = "REPLACE INTO session_old (id, session) VALUES (1, '".$sess_now."') ";
            $result_2 = $conn->query($sql_2);
        }
        
        $sql = "UPDATE session_now SET `session` = NULL WHERE id = '1' ";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            // throw new Exception("Error: " . $sql . "<br>" . $conn->error);
            return false;
        }
    }

    function get_session_before(){

        include 'config.php';

        $sql = "SELECT session FROM session_old WHERE id = '1' ";
        $result = $conn->query($sql);
        
        $session_before = "";
        while ($rows = $result->fetch_assoc()) {
            $session_before = $rows['session'];
        }

        return $session_before;
    }

    function get_list_barang_not_scanable(){

        include 'config.php';

        $sql = "SELECT * FROM master_harga WHERE scanable = '2'";
        $result = $conn->query($sql);

        $data = array();
        $i = 0;
        // $opt = '<option disabled selected>Pilih Barang</option>';
        while ($rows = $result->fetch_assoc()) {
            // $opt .= '<option value="'.$rows['code'].'">'.$rows['nama_product'].'</option>';
            $data[$i]['id'] = $rows['code'];
            $data[$i]['text'] = $rows['nama_product'];

            $i++;
        }

        return $data;

    }

?>