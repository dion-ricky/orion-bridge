<?php
if(isset($_SESSION['SES_ADMIN'])) {
?>
<div class="vertical-menu">
<ul>
<li><a href='?page' title='Halaman Utama' class="active">Home</a></li>
<li><a href='?page=User-Data' title='User Login'>Data User</a></li>
<li><a href='?page=Supplier-Data' title='Supplier'>Data Supplier</a></li>
<li><a href='?page=Pelanggan-Data' title='Pelanggan'>Data Pelanggan</a></li>
<li><a href='?page=Kategori-Data' title='Kategori'>Data Kategori</a></li>
<li><a href='?page=Barang-Data' title='Barang'>Data Barang</a></li>
<li><a href='?page=Pencarian' title='Pencarian'>Pencarian</a></li>
<li><a href='pembelian/' title='Transaksi Pembelian' target='_blank'>Transaksi Pembelian</a></li>
<li><a href='penjualan/' title='Transaksi Penjualan' target="_blank">Transaksi Penjualan</a></li>
<li><a href='?page=Laporan' title='Laporan'>Laporan</a></li>
<li><a href='?page=Logout' title='Logout'>Logout</a></li>
</ul>
</div>
<?php
}
elseif(isset($_SESSION['SES_CASHIER'])) {
?>
<div class="vertical-menu">
<ul>
<li><a href='?page' title='Halaman-Utama'>Home</a></li>
<li><a href='pembelian/' title='Transaksi-Pembelian' target='_blank'>Transaksi Pembelian</a></li>
<li><a href='penjualan/' title='Transaksi-Penjualan' target='_blank'>Transaksi Penjualan</a></li>
<li><a href='?page=Logout' title='Logout'>Logout</a></li>
</ul>
</div>
<?php
}
else {
?>
<div class="vertical-menu">
<ul>
<li><a href='?page=Login' title='Login'>Login</a></li>
</ul>
</div>
<?php
}
?>