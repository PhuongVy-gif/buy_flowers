<?php
session_start();
function find_flower($flower_name, $flower_arr) {
    $found = 0;
    foreach ($flower_arr as $flower) {
        if (strcasecmp($flower_name, $flower) == 0) {
            $found = 1;
            break;
        }
    }
    return $found;
}
$message = '';
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['add'])) {
    $flower_name = trim($_POST['flower'] ?? '');
    if ($flower_name !== '') {
        if (find_flower($flower_name, $_SESSION['cart'])) {
            $message = "Flower $flower_name is already in the cart";
        } else {
            $_SESSION['cart'][] = $flower_name;
        }
    }
} else if (isset($_POST['clear'])) {
    $_SESSION['cart'] = [];
} else if (isset($_POST['remove']) && isset($_POST['remove_flower'])) {
    $remove = $_POST['remove_flower'];
    $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], function($flower) use ($remove) {
        return strcasecmp($flower, $remove) !== 0;
    }));
}
$cart_display = '-- ' . implode(' -- ', $_SESSION['cart']) . ' --';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Flowers</title>
    <style>
        body { background: linear-gradient(135deg, #f8fffa 0%, #ffe0e0 100%); min-height: 100vh; margin: 0; }
        .container {
            max-width: 540px;
            margin: 48px auto 0 auto;
            border: none;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(255, 170, 170, 0.25), 0 1.5px 8px #fbb;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #ffb347 0%, #ffcc80 100%);
            text-align: center;
            padding: 22px 0 14px 0;
            font-size: 2.3em;
            font-weight: bold;
            font-style: italic;
            letter-spacing: 2px;
            color: #b22;
            border-radius: 18px 18px 0 0;
            box-shadow: 0 2px 8px #ffe0e0;
        }
        .form-section {
            padding: 28px 32px 18px 32px;
        }
        label {
            font-weight: bold;
            color: #b22;
            min-width: 120px;
            display: inline-block;
            font-size: 1.08em;
        }
        .row { margin-bottom: 18px; }
        .row.flex { display: flex; align-items: center; gap: 10px; }
        input[type="text"] {
            width: 100%;
            max-width: 360px;
            font-size: 1em;
            padding: 7px 10px;
            border-radius: 6px;
            border: 1px solid #e0b;
            background: #fff8f8;
            transition: border 0.2s;
        }
        input[type="text"]:focus {
            border: 1.5px solid #ffb347;
            outline: none;
        }
        textarea {
            width: 100%;
            height: 60px;
            font-size: 1em;
            margin-top: 5px;
            resize: none;
            background: #fff8f8;
            border-radius: 6px;
            border: 1px solid #e0b;
            padding: 7px;
        }
        .btn-add {
            min-width: 140px;
            background: linear-gradient(90deg, #ffb347 0%, #ffd580 100%);
            color: #b22;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 1em;
            padding: 8px 0;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px #ffe0e0;
        }
        .btn-add:hover {
            background: #ffe0b2;
            box-shadow: 0 4px 16px #ffd580;
        }
        .btn-clear {
            height: 38px;
            min-width: 110px;
            margin: 0 auto;
            display: block;
            background: linear-gradient(90deg, #e44 0%, #ff8888 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 10px;
            font-size: 1em;
            box-shadow: 0 2px 8px #ffe0e0;
        }
        .btn-clear:hover {
            background: #c22;
        }
        .btn-remove {
            min-width: 110px;
            margin: 0 auto;
            display: block;
            background: linear-gradient(90deg, #4a90e2 0%, #8ec6ff 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 0;
            font-size: 1em;
            font-weight: bold;
            margin-left: 12px;
            box-shadow: 0 2px 8px #e0eaff;
        }
        .btn-remove:hover {
            background: #357ab8;
        }
        .center-row { display: flex; justify-content: center; margin-top: 18px; }
        select {
            min-width: 140px;
            font-size: 1em;
            border-radius: 6px;
            border: 1px solid #e0b;
            padding: 7px;
            background: #fff8f8;
        }
        .msg {
            color: #e44;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        @media (max-width: 500px) {
            .container { max-width: 98vw; margin: 16px 1vw; }
            .form-section { padding: 16px 4vw 10px 4vw; }
            .header { font-size: 1.3em; padding: 12px 0 8px 0; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">BUY FLOWERS</div>
    <form name="frmBuyFlowers" method="post" action="flower.php">
        <div class="form-section">
            <div class="row flex">
                <label for="flower">Flower type:</label>
                <input type="text" id="flower" name="flower" autocomplete="off" value="<?php echo (isset($_POST['add']) && empty($message)) ? '' : (isset($_POST['flower']) ? htmlspecialchars($_POST['flower']) : ''); ?>">
                <button type="submit" name="add" class="btn-add">Add to cart</button>
            </div>
            <?php if ($message) { echo '<div class="msg">'.$message.'</div>'; } ?>
            <div class="row">
                <label>Your flower cart:</label>
                <textarea readonly><?php echo $cart_display; ?></textarea>
            </div>
            <div class="center-row">
                <button type="submit" name="clear" class="btn-clear">Clear cart</button>
            </div>
            <div class="center-row" style="margin-top:10px;">
                <select name="remove_flower">
                    <?php foreach ($_SESSION['cart'] as $flower) {
                        echo '<option value="'.htmlspecialchars($flower).'">'.htmlspecialchars($flower).'</option>';
                    } ?>
                </select>
                <button type="submit" name="remove" class="btn-remove">Remove selected</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>