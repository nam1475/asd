<?php
include "../../includes/LeadControl.php";

$lead = new Lead();
$helper = new Helper();
$customers = $helper->selectAll('customer');
$leadSources = $helper->selectAll('lead_source');

if(isset($_POST['submit'])){
    $data = [
        'customer_id' => $_POST['customer_id'],
        'source_id' => $_POST['source_id'],
    ];
    $errors = $lead->validate($data);

    /* Nếu không xảy ra lỗi khi validate */
    if (empty($errors)) {
        /* Nếu chưa tồn tại khách hàng(customer_id) */
        if(!$lead->isExist($data)) {
            $result = $helper->addRow('lead', $data);
            if($result) {
                $_SESSION['success'] = "Thêm khách hàng tiềm năng thành công!";
                header('Location: ../layouts/main.php?action=lead-list');
            } else {
                $_SESSION['error'] = "Đã xay ra lỗi!";
            }
        }
        else{
            $_SESSION['error'] = "Dữ liệu đã tồn tại!";
            header('Location: ../layouts/main.php?action=lead-list');
        }
    }

}
?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-head-line">Thêm khách hàng tiềm năng</h1>
            </div>
        </div>
        <!-- /. ROW  -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <form role="form" method="POST" action="">
                            <div class="form-group">
                                <label>Chọn khách hàng</label>
                                <select name="customer_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($customers as $customer) {
                                    ?>
                                        <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger">
                                    <?php
                                    if (isset($errors['customer_id']['required'])) {
                                        echo $errors['customer_id']['required'];
                                    }
                                    ?>
                                </div>
                            </div>
                                    
                            <div class="form-group">
                                <label>Chọn nguồn khách hàng tiềm năng</label>
                                <select name="source_id">
                                    <option value=""></option>
                                    <?php
                                    foreach ($leadSources as $ls) {
                                    ?>
                                        <option value="<?= $ls['id'] ?>"><?= $ls['name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="text-danger">
                                    <?php
                                    if (isset($errors['source_id']['required'])) {
                                        echo $errors['source_id']['required'];
                                    }
                                    ?>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-info">Lưu</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

