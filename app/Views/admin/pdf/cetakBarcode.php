<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <title><?= get_nama_perusahaan() ?> | Cetak Barcode</title>
    <style>
        html {
            font-family: "Verdana, Arial";
            color: #333;
        }

        .container {
            
            font-size: 12px;
            padding: 5px;
        }

        .title {
            text-align: center;
            font-size: 13px;
            padding-bottom: 5px;
            /* border-bottom: 1px dashed; */
        }

        .title h2,
        p {
            margin-bottom: 0;
            margin-top: 0;
        }

        .head {
            margin-top: 5px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            /* border-bottom: 1px solid; */
        }

        .table {
            width: 100%;
            font-size: 11px;
        }

        .kiri {
            text-align: left;
        }

        .kanan {
            text-align: right;
        }

        .terimakasih {
            margin-top: 10px;
            padding-top: 10px;
            text-align: center;
        }

        @media print {
            @page {
                width: 80mm;
                margin: 0mm;
            }
        }
    </style>

</head>

<body onload="print()">
    <div class="container">
    <?php
    for ($i = 1; $i <= 108; $i++) {
      echo '<img id="code128" width="80" height="10" style="border: 1px solid black; max-width: 100%; height: auto; margin:0 2px">';
    }
    ?>
    
    
</div>
    </div>
    <script>
    JsBarcode("#code128", "<?= $barcode ?>",{
                        displayValue: true, 
                        fontSize: 20

                    });
    </script>
   
</body>

</html>