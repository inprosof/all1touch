<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print BarCode</title>
    <style>  @page {
            margin: 0 auto;
            sheet-size: <?php echo $style['width'] ?>mm  <?php echo $style['height'] ?>mm;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<table cellpadding="<?php echo $style['padding'] ?>" style="width: 100%">
    <?php
    foreach ($products as $lab) {
        for ($i = 0; $i <= $style['total_rows']; $i++) { ?>
            <tr>
                <?php  for ($z =0; $z <= $style['items_per_row']; $z++) { ?>
                <td style="border: 1px solid;" class="text-center"><strong><?php echo $lab['product_name'] ?></strong><br>
                    <?php if ($style['product_code']) echo '<br>' . $style['product_code'] . $lab['product_code'];
                    if ($style['warehouse_name']) echo '<br>' . $style['warehouse'] ?>
                    <br><br>
                    <barcode code="<?php echo $lab['barcode'] ?>" text="1" class="barcode"
                             height="<?php echo $style['bar_height'] ?>"/>
                    </barcode><br><br>
                    <br><?php if ($style['store_name']) echo $style['store'] . '<br><br>';
                    if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                    ?>
                    <h3><?php if ($style['product_price']) echo amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) . '<br><br>'; ?></h3>
                </td>
<?php } ?>
                <?php
                if ($style['items_per_row'] == 'x2') {

                    ?>
                    <td style="border: 1px solid;" class="text-center"><strong><?php echo $lab['product_name'] ?></strong>


                        <?php if ($style['product_code']) echo '<br>' . $lab['product_code'] ?>
                        <?php if ($style['warehouse_name']) echo $style['warehouse_name'] . '<br>' . $style['warehouse'] ?>
                        <br><br>
                        <barcode code="<?php echo $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?php echo $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br> <?php if ($style['store_name']) echo $style['store'] . '<br><br>'; ?>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?php echo amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>

                    <?php

                }
                                if ($style['items_per_row'] >  'x2') {

                    ?>
                    <td style="border: 1px solid;" class="text-center"><strong><?php echo $lab['product_name'] ?></strong>


                        <?php if ($style['product_code']) echo '<br>' . $lab['product_code'] ?>
                        <?php if ($style['warehouse_name']) echo $style['warehouse_name'] . '<br>' . $style['warehouse'] ?>
                        <br><br>
                        <barcode code="<?php echo $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?php echo $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br> <?php if ($style['store_name']) echo $style['store'] . '<br><br>'; ?>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?php echo amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>
                    <td style="border: 1px solid;" class="text-center">
                        <strong><?php echo $lab['product_name'] ?></strong><br><?php echo $lab['product_code'] ?>
                        <br><?php echo $style['warehouse'] ?><br><br>
                        <barcode code="<?php echo $lab['barcode'] ?>" text="1" class="barcode"
                                 height="<?php echo $style['bar_height'] ?>"/>
                        </barcode><br><br>
                        <br><?php echo $style['store'] ?><br><br>
                        <?php
                        if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
                        ?>
                        <h3><?php echo amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
                    </td>
                    <?php

                }
                ?>


            </tr>
        <?php }
    } ?>

</table>
</body>
</html>