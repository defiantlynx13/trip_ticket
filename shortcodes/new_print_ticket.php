<!doctype html>
<html>
    
    <head>
        <title>چاپ بلیط</title>
        <style>
            .print_table{
                border:1px solid #ddd;
                padding:20px;
                width:95%;
                margin:0 auto;
            }
            .print_table table{
                width:100%;
            }
            .print_table th{
                text-align:right;
                padding:10px;
            }
            .qrcode img{
                display:block;
                margin:0 auto;
            }
        </style>
    </head>

<body style="direction:rtl;text-align:right;font-family:IRANSansWeb;font-size:15px;box-sizing:border-box;">
<?php

defined("ABSPATH") || exit;
 
 ?>
                <br>
            <button id="this" onclick="getElementById('this').style.display = 'none';window.print();return false;" style="margin: 0 auto;display: inherit;background: #87907D;border: 0;padding:10px 20px;color:#fff;border-radius:3px;box-shadow:0 0 10px #eee;cursor:pointer;font-size:.9em;font-family:IRANSansWeb">پرینت بلیط</button>
 
 
                <div style="width:95%;margin:20px auto;border:4px solid #eee;padding:15px 10px;overflow:hidden;border-radius:3px;">
                
                <div style="width:60%;float:right;margin-bottom:15px;">
                    
                    
                    <div style="overflow:hidden">
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;float:right;box-sizing:border-box;padding:15px;"><strong>نام مسافر: </strong>&nbsp; <?php echo $_GET['names']?> </div>
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;float:left;box-sizing:border-box;padding:15px;"><strong>شماره ملی: </strong>&nbsp;<?php echo $_GET['melli']?></div>
                    </div>
                    
                    <div style="overflow:hidden">
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;margin-top:10px;float:right;box-sizing:border-box;padding:15px;"><strong>زمان: </strong>&nbsp;<?php echo $_GET['time']?></div>
                        <div style="border:2px solid #eee;border-radius:5px;width:49.5%;margin-top:10px;float:left;box-sizing:border-box;padding:15px;"><strong>شماره صندلی: </strong>&nbsp;<?php echo $_GET['number']?></div>
                    </div>
                    
                    <div style="overflow:hidden">
                        
                        <div style="border:2px solid #eee;border-radius:5px;width:100%;margin-top:10px;float:left;box-sizing:border-box;padding:15px;"><strong>نوع کشتی: </strong>&nbsp;<?php echo $_GET['type']?></div>
                    </div>
                    <?php 
					if( isset( $_GET['route'] ) ){
					?>
                    <div style="border:2px solid #eee;padding:15px;border-radius:5px;margin-top:10px;"><strong>مسیر: </strong>&nbsp;<?php echo $_GET['route']; ?></div>
                    <?php
					}
					?>
                </div>
                
                <div style="width:39%;float:left;margin-bottom:30px">
                    
                    
                    
                    <div style="border:2px solid #eee;padding:15px;border-radius:5px;overflow:hidden">
                        
                        <div style="width:100%;float:left;box-sizing:border-box;" class="qrcode">
                            <?php echo do_shortcode('[auto_qrcode qrcode='.$_GET['pass'].' size=6 ,margin=4]'); ?>
                        </div>
                    </div>
                    
                </div>
                
                <div style="border:2px solid #eee;padding:15px;border-radius:5px;margin-top:10px;clear:both"><strong>توضیحات: </strong>&nbsp;
                        <p style="font-size:15px;text-align:justify">*  <?php echo get_option('tt_print_page_desc1'); ?></p>
                        <p style="font-size:15px;text-align:justify;margin-bottom:0">* <?php echo get_option('tt_print_page_desc2'); ?></p>
                        <p style="font-size:15px;text-align:justify;margin-bottom:0">* <?php echo get_option('tt_print_page_desc3'); ?></p>
                </div>
                
            </div>
            
            
            
            <br><br>
            <div style="border-bottom:1px dashed #777"></div>
            <br><br>
                        

    </body>
</html>