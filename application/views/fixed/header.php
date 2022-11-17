<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="<?php echo LTR ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>All1Touch - CRM</title >";
    }
    ?>

    <link rel="apple-touch-icon" href="<?php echo assets_url() ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url() ?>app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/vendors.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/tables/extensions/buttons.dataTables.min.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/fonts/simple-line-icons/style.css">

    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/<?php echo LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/summernote-bs4.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>app-assets/vendors/css/forms/selects/select2.min.css">

    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url() ?>assets/css/style.css<?php echo APPVER ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url() ?>assets/css/fonts/bootstrap-icons.css">
    <?php if (LTR == 'rtl') echo '<link rel="stylesheet" type="text/css" href="' . assets_url() . 'assets/css/style-rtl.css' . APPVER . '">'; ?>
    <!-- END Custom CSS-->
    <script src="<?php echo assets_url() ?>app-assets/vendors/js/vendors.min.js"></script>
    <script type="text/javascript" src="<?php echo assets_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script type="text/javascript"
            src="<?php echo assets_url() ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>


    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.1/accounting.js"
            integrity="sha512-1hc1qo8amzs9GZbiWKAkl2YULo48W4Xk6xjdjvjTlsiQ62Hft2NuSeNrLxTnSigNstumZzOOCYMDDcDwjrogDw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	-->

    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?php echo assets_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <?php accounting() ?>
</head>
<?php
$id = $this->aauth->get_user()->lang;
$this->lang->load($id, $id);
$this->lang->load('part', $id);
if (MENU) {
    include_once('header-va.php');
} else {
    include_once('header-ha.php');
}
