<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>	
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
<div class="container-fluid" style="width: 680px;">
  <div style="float: right; margin-left: 20px;">
	  <a href="" title=""><img src="" alt="" style="margin-bottom: 20px; border: none;" /></a>
  </div>
  <div>
    <p style="margin-top: 0px; margin-bottom: 20px;"><?php echo $text_message; ?></p>
    <p style="margin-top: 0px; margin-bottom: 20px;"><?php //echo $text_from; ?></p>
    

  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;"><?php echo $text_product; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: center; padding: 7px; color: #222222;"><?php echo $text_image; ?></td>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;"><?php echo $text_price; ?></td>
      </tr>
    </thead>
   <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><?php echo $product['name']; ?></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: center; padding: 7px;">
			<a href="<?php echo $link; ?>index.php?route=product/product&product_id=<?php echo $product['productid']; ?>">
				<img src="<?php echo $product['image']; ?>" style="margin-bottom: 20px; border: none;" /></a></td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">Rs. <?php echo $product['price']; ?></td>
      </tr>
      <?php } ?>    
    </tbody>
  </table>    
  </div>
</div>
</body>
</html>
