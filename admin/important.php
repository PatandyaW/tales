<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>
<?php 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

  
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>


<div class="content-wrapper">
<section class="content">
<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "ecomm");

// Query untuk mengambil data dari tabel

$query8 = "
SELECT 
CASE
	WHEN MONTH(sales.sales_date) = 1 THEN 'Januari'
    WHEN MONTH(sales.sales_date) = 2 THEN 'Februari'
    WHEN MONTH(sales.sales_date) = 3 THEN 'Maret'
    WHEN MONTH(sales.sales_date) = 4 THEN 'April'
    WHEN MONTH(sales.sales_date) = 5 THEN 'Mei'
    WHEN MONTH(sales.sales_date) = 6 THEN 'Juni'
    WHEN MONTH(sales.sales_date) = 7 THEN 'Juli'
    WHEN MONTH(sales.sales_date) = 8 THEN 'Agustus'
    WHEN MONTH(sales.sales_date) = 9 THEN 'September'
    WHEN MONTH(sales.sales_date) = 10 THEN 'Oktober'
    WHEN MONTH(sales.sales_date) = 11 THEN 'November'
    WHEN MONTH(sales.sales_date) = 12 THEN 'Desember'
    END AS Month,SUM(details.quantity) AS Total FROM details JOIN sales ON details.sales_id=sales.id GROUP BY MONTH(sales.sales_date);
";

// Eksekusi query
$result = mysqli_query($conn, $query8);

// Ambil data dari hasil query
$data8 = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data8[] = $row;
}

// Ekstraksi bulan dan total penjualan
$bulan = array_column($data8, 'Month');
$total_penjualan = array_column($data8, 'Total');
// Tutup koneksi




$query1 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 1
GROUP BY months.month, products.category_id;
";

$query2 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 2
GROUP BY months.month, products.category_id;
";

// Query SQL ke-3
$query3 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 3
GROUP BY months.month, products.category_id;
";

// Query SQL ke-4
$query4 = "
SELECT
months.month,
products.category_id,
COALESCE(SUM(details.quantity), 0) AS total_penjualan
FROM (
SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8
UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12
) AS months
JOIN products
LEFT JOIN sales ON MONTH(sales.sales_date) = months.month
LEFT JOIN details ON details.sales_id = sales.id
AND details.product_id = products.id
WHERE products.category_id = 4
GROUP BY months.month, products.category_id;
";

// Eksekusi query pertama
$result1 = mysqli_query($conn, $query1);
$data1 = array();
while ($row = mysqli_fetch_assoc($result1)) {
    $data1[] = $row['total_penjualan'];
}

// Eksekusi query kedua
$result2 = mysqli_query($conn, $query2);
$data2 = array();
while ($row = mysqli_fetch_assoc($result2)) {
    $data2[] = $row['total_penjualan'];
}

// Eksekusi query ke3
$result3 = mysqli_query($conn, $query3);
$data3 = array();
while ($row = mysqli_fetch_assoc($result3)) {
    $data3[] = $row['total_penjualan'];
}

// Eksekusi query ke4
$result4 = mysqli_query($conn, $query4);
$data4 = array();
while ($row = mysqli_fetch_assoc($result4)) {
    $data4[] = $row['total_penjualan'];
}

// Tampilkan hasil dalam bentuk bar chart


$query = "SELECT 
CASE
	WHEN MONTH(sales.sales_date) = 1 THEN 'Januari'
    WHEN MONTH(sales.sales_date) = 2 THEN 'Februari'
    WHEN MONTH(sales.sales_date) = 3 THEN 'Maret'
    WHEN MONTH(sales.sales_date) = 4 THEN 'April'
    WHEN MONTH(sales.sales_date) = 5 THEN 'Mei'
    WHEN MONTH(sales.sales_date) = 6 THEN 'Juni'
    WHEN MONTH(sales.sales_date) = 7 THEN 'Juli'
    WHEN MONTH(sales.sales_date) = 8 THEN 'Agustus'
    WHEN MONTH(sales.sales_date) = 9 THEN 'September'
    WHEN MONTH(sales.sales_date) = 10 THEN 'Oktober'
    WHEN MONTH(sales.sales_date) = 11 THEN 'November'
    WHEN MONTH(sales.sales_date) = 12 THEN 'Desember'
END AS Month, SUM(details.quantity*(products.price)) AS Total
FROM details 
JOIN sales ON details.sales_id=sales.id 
JOIN products ON details.product_id = products.id
GROUP BY  MONTH(sales.sales_date);
";
$res = mysqli_query($conn, $query);

// Inisialisasi array untuk menyimpan bulan dan total penjualan
$bulanData = array();
$totalData = array();

// Mengambil data dari hasil query dan menyimpannya ke dalam array
while ($data = mysqli_fetch_array($res)) {
    $bulanData[] = $data['Month'];
    $totalData[] = $data['Total'];
}

// Menutup koneksi ke database
mysqli_close($conn);
?>


    <!-- Load library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="row">
        <div class="col-xs-6">
          <div class="box">
    <div class="box-body">
              <div class="linechart">
    <canvas id="lineChart" height="100px"></canvas>
    </div>
            </div>
</div>
</div>
<div class="col-xs-6">
          <div class="box">
    <div class="box-body">
    <div class="barchart">
    <canvas id="bar" height="100px"></canvas>
    </div>
  </div>
</div>
</div>
</div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <div class="row">
        <div class="col-xs-12">
          <div class="box">
    <div class="box-body">
    <div class="barchart">
    <canvas id="barChart" height="100px"></canvas>
    </div>
  </div>
</div>
</div>
</div>


      
</div>
</section>
<?php include 'includes/footer.php'; ?>
    </div>
    
    <script>
        // Mengambil data dari PHP dan menyimpannya dalam variabel JavaScript
        var bulanData = <?php echo json_encode($bulanData); ?>;
        var totalData = <?php echo json_encode($totalData); ?>;

        // Membuat chart menggunakan Chart.js
        var ctx = document.getElementById('lineChart').getContext('2d');
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: bulanData,
                datasets: [{
                    label: 'Total Pendapatan Bulanan (dalam RP)',
                    data: totalData,
                    fill: true,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


<script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [
                    {
                        label: 'Tanaman Hias',
                        data: <?php echo json_encode($data1); ?>,
                        backgroundColor: 'rgba(255, 0, 0, 0.5)',
                        borderColor: 'rgba(255, 0, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bibit Buah',
                        data: <?php echo json_encode($data2); ?>,
                        backgroundColor: 'rgba(255, 165, 0, 0.5)',
                        borderColor: 'rgba(255, 165, 0, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Bibit Sayur',
                        data: <?php echo json_encode($data3); ?>,
                        backgroundColor: 'rgba(0, 0, 255, 0.5)',
                        borderColor: 'rgba(0, 0, 255, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Tanaman Aromatik',
                        data: <?php echo json_encode($data4); ?>,
                        backgroundColor: 'rgba(0, 128, 0, 0.5)',
                        borderColor: 'rgba(0, 128, 0, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        // Membuat bar chart dengan menggunakan Chart.js
        var ctx = document.getElementById('bar').getContext('2d');
        var barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($bulan); ?>,
                datasets: [{
                    label: 'Total Penjualan Bulanan (Unit)',
                    data: <?php echo json_encode($total_penjualan); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    </body>



    
    



    
