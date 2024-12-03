<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nota</title>
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
<?php
    include 'koneksi.php';
    $id = (int)$_GET['id'];

    $trans = "SELECT * FROM tb_detail
    INNER JOIN tb_transaksi on tb_detail.id_transaksi = tb_transaksi.id_transaksi
    where tb_detail.id_transaksi='$id'";
    $query = mysqli_query($koneksi, $trans);
    $data = mysqli_fetch_array($query);

    $res = "SELECT * FROM tb_transaksi
    INNER JOIN tb_user on tb_transaksi.id_pelanggan = tb_user.id
    where tb_transaksi.id_transaksi='$id'";
    $query = mysqli_query($koneksi, $res);
    $user = mysqli_fetch_array($query);
    ?>

    <div class="max-w-2x1 mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-2x1 font-bold text-center mb-4">Nota pembelian</h2>

        <div class="mb-4">
            <p class="text-sm text-gray-600">No Nota : <span class="font-semibold"><?php echo $id?></span></p>
            <p class="text-sm text-gray-600">No Nota : <span class="font-semibold"><?php echo $user['nama']?></span></p>
            <p class="text-sm text-gray-600">Tanggal : <span class="font-semibold"><?php echo $data['tanggal']?></span></p>
        </div>

        <table class="min-w-full bg-white"> 
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200 text-left text-sm font-semibold text-gray-700">deksripsi</th>
                    <th class="py-2 px-4 bg-gray-200 text-left text-sm font-semibold text-gray-700">Kuantitas</th>
                    <th class="py-2 px-4 bg-gray-200 text-left text-sm font-semibold text-gray-700">harga</th>
                    <th class="py-2 px-4 bg-gray-200 text-left text-sm font-semibold text-gray-700">transliterator_transliterate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total =0;
                    $prod = "SELECT * FROM tb_detail INNER JOIN produk on tb_detail.id_produk = produk.id where tb_detail.id_transaksi=$id";
                    $query2 = mysqli_query($koneksi, $prod);
                    while($row = mysqli_fetch_array($query2)){
                        $total = $total + ($row['harga'] * $row['jumlah'])
                
                ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?php echo $row['nama']?></td>
                    <td class="py-2 px-4 border-b"><?php echo $row['jumlah']?></td>
                    <td class="py-2 px-4 border-b"><?php echo $row['harga']?></td>
                    <td class="py-2 px-4 border-b"><?php echo $row['harga'] * $row['jumlah']?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                <td colspan="3" class="pu-2 px-4 text-right font-semibold">Total</td>
                <td class="py-2 px-4 text-right">
                    <?php echo number_format($total)?>
                </td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray">terimakasih udah membeli produk kami</p>
            <button class="text-slate-50 bg-slate-900 px-5 py-1" id="print">print</button>
        </div>
    </div>

    <script>
        document.getElementById("print").addEventListener('click', () => {
            window.print();
        })
    </script>
</body>
</html>