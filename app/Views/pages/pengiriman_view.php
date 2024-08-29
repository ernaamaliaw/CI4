<?= $this->extend('components/layout') ?>
<?= $this->section('content') ?>
<?php
if(session()->getFlashData('success')){
?> 
<div class="alert alert-info alert-dismissible fade show" role="alert">
	<?= session()->getFlashData('success') ?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>
<?php
if(session()->getFlashData('failed')){
?> 
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<?= session()->getFlashData('failed') ?>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>
<!-- Table with stripped rows -->
<table class="table datatable">
<thead>
	<tr>
	<th scope="col">#</th>
	<th scope="col">Tanggal</th>
	<th scope="col">Username</th>
	<th scope="col">Total Harga</th> 
	<th scope="col">Ongkir</th>
	<th scope="col">Status</th>
	<th scope="col"></th> 
	</tr>
</thead>
<tbody>
	<?php foreach($transaksi as $index=>$transaksi): ?>
	<tr>
	<th scope="row"><?php echo $index+1?></th>
	<td><?php echo $transaksi['created_date'] ?></td> 
	<td><?php echo $transaksi['username'] ?></td>
    <td><?php echo $transaksi ['total_harga'] ?></td>
    <td> <?= $transaksi['ongkir']?></td>
    <td>
        <form action="<?= base_url('pengiriman/edit/'.$transaksi['id']) ?>" method="post">
            <?php
            if($transaksi['status']==0){
                echo form_hidden('id',$transaksi['id']);
                echo form_hidden('status',1);
                ?>
            <button type="submit" class="btn btn-success" > 
                Diproses
            </button>
            <?php
		}else if ($transaksi['status']==1){
			echo form_hidden('id',$transaksi['id']);
			echo form_hidden('status',2);?>
			<button type="submit" class="btn btn-warning">Dikirim</button>
<?php
		}else{
			echo form_hidden('id',$transaksi['id']);
		?>
		<p class="btn btn-success">Selesai</p>
		<?php } ?>
		</form>
	</td>
	
	<?php endforeach;?>
	</tr>   
</tbody>
</table>

<?= $this->endSection() ?>