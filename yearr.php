<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LUNAR YEAR CALCULATOR</title>
    <style>
        body { background: #aee3fa; font-family: Arial; }
        .container { width: 600px; margin: 40px auto; background: #bfe6ff; border-radius: 8px; box-shadow: 0 0 8px #888; padding: 20px; text-align: center; }
        h2 { color: #fff; background: #1976d2; padding: 10px 0; border-radius: 6px; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif; }
        label { display: inline-block; width: 110px; text-align: left; }
        input[type="text"] { width: 120px; padding: 5px; font-size: 16px; }
        input[readonly] { background: #fff8dc; color: #c62828; font-weight: bold; }
        .row { margin-bottom: 15px; }
        .btn { padding: 5px 18px; font-size: 16px; background: #ffeb3b; border: 1px solid #888; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .animal-img { margin-top: 15px; }
    </style>
</head>
<body>
<div class="container">
    <h2>LUNAR YEAR CALCULATOR</h2>
    <form name="form_lunar_year" method="post" action="yearr.php">
        <div class="row" style="display: flex; align-items: center; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <label for="solar_year" style="width: 110px;">Solar year</label>
            <input type="text" name="solar_year" id="solar_year" value="<?php echo isset($_POST['solar_year']) ? htmlspecialchars($_POST['solar_year']) : '' ?>">
            <button class="btn" type="submit" name="calc">=&gt;</button>
            <label for="lunar_year" style="width: 90px; margin-left: 10px;">Lunar year</label>
            <input type="text" name="lunar_year" id="lunar_year" value="<?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solar_year']) && is_numeric($_POST['solar_year'])) {
                    $year = intval($_POST['solar_year']);
                    $can_arr = array("Quy", "Giap", "At", "Binh", "Dinh", "Mau", "Ky", "Canh", "Tan", "Nham");
                    $chi_arr = array("Hoi", "Ty", "Suu", "Dan", "Mao", "Thin", "Ty", "Ngo", "Mui", "Than", "Dau", "Tuat");
                    $year_calc = $year - 3;
                    $can = $year_calc % 10;
                    $chi = $year_calc % 12;
                    echo $can_arr[$can] . ' ' . $chi_arr[$chi];
                }
            ?>" readonly>
        </div>
    </form>
    <div class="animal-img">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['solar_year']) && is_numeric($_POST['solar_year'])) {
            $year = intval($_POST['solar_year']);
            $can_arr = array("Quy", "Giap", "At", "Binh", "Dinh", "Mau", "Ky", "Canh", "Tan", "Nham");
            $chi_arr = array("Hoi", "Ty", "Suu", "Dan", "Mao", "Thin", "Ty", "Ngo", "Mui", "Than", "Dau", "Tuat");
            $img_arr = array(
                '12_con_giap/hoi.jpg', // Hoi
                '12_con_giap/ty.jpg', // Ty
                '12_con_giap/suu.jpg', // Suu
                '12_con_giap/dan.jpg', // Dan
                '12_con_giap/mao.jpg', // Mao
                '12_con_giap/thin.jpg', // Thin
                '12_con_giap/tyy.jpg', // Ty (snake)
                '12_con_giap/ngo.jpg', // Ngo
                '12_con_giap/mui.jpg', // Mui
                '12_con_giap/than.jpg', // Than
                '12_con_giap/dau.jpg', // Dau
                '12_con_giap/tuat.jpg'  // Tuat
            );
            $year_calc = $year - 3;
            $can = $year_calc % 10;
            $chi = $year_calc % 12;
            $img_src = $img_arr[$chi];
            echo "<div style='display:inline-block; border:2px solid #1976d2; border-radius:10px; padding:10px; background:#fff;'>";
            echo "<img src='$img_src' alt='" . $chi_arr[$chi] . "' width='120'><br>";
            echo "<span style='font-weight:bold; color:#1976d2; font-size:18px;'>" . $chi_arr[$chi] . "</span>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>