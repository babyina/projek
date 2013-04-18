<?php
if($_GET['action']=="NewDoc"){?>
	<br/><form name="borang" method="post">
	<div class="title">Katakunci</div>
	<div class="box">
	<table>				
		<tr><td colspan="5"><br/></td></tr>
		<tr><td width="5"/><td width="83">Kategori</td><td width="3">:</td><td width="280"><select id="kategori" name="kategori" onChange="showDk();showDesc(this.selectedIndex)"><option/><?php ListKategori($keyword) ?></select><div id="desc"></div></td></tr>
		<tr><td width="5"/><td>Kod</td><td>:</td><td><input type="text" class="txt"  name="kod" value="" size="50"/></td></tr>
		<tr><td width="5"/><td>Butiran</td><td>:</td><td><input name="butiran" class="txt" size="50"/></td></tr>
		<tr><td width="5"/><td><div id="dk1">Diketuai Oleh</div></td><td><div id="dk2">:</div></td><td><div id="dk3"><input name="butiran2" class="txt" size="50"/>
		</div></td></tr>
		<tr><td width="5"/><td colspan="3"><br/><input type="submit" name="Simpan" value="SIMPAN" class="button"/><br/><br/></td></tr>
	</table>	
	</div>
	</form>	
<?php
}elseif($_GET['action']=='EditDoc'){?>
	<br/><form name="borang" method="post">
	<div class="title">Katakunci</div>
	<div class="box">
	<table>				
		<tr><td colspan="4"><br/></td></tr>
		<tr><td width="5"/><td>Kategori</td><td>:</td><td><select onChange="showDk()" name="kategori"><option/><?php ListKategori($keyword,$row['kategori']) ?></select></td></tr>
		<tr><td width="5"/><td>Kod</td><td>:</td><td><input type="text" class="txt" name="kod" value="<?php echo $row['kod']?>" size="30"/></td></tr>
		<tr><td width="5"/><td>Butiran</td><td>:</td><td><input name="butiran" class="txt" size="30" value="<?php echo $row['butiran']?>"/></td></tr>
		<tr><td width="5"/><td><div id="dk1">Diketuai Oleh</div></td><td><div id="dk2">:</div></td><td><div id="dk3"><input name="butiran2" class="txt" size="30" value="<?php echo $row['butiran2'] ?>"/></div></td></tr>
		<tr><td width="5"/><td colspan="3"><br/><input type="submit" name="Kemaskini" value="SIMPAN" class="button"/><br/><br/></td></tr>
	</table>	
	</div>
	</form>	
<?php
}elseif($_GET['action']=='OpenDoc'){?>
	<br/><form name="borang" method="post" action="index.php?mode=Keyword&action=EditDoc&id=<?php echo $id?>">
	<div class="title">Katakunci</div>
	<div class="box">
	<table>				
		<tr><td colspan="4"><br/></td></tr>
		<tr><td width="5"/><td>Kategori</td><td>:</td><td><?php echo $row['kategori']?></td></tr>
		<tr><td width="5"/><td>Kod</td><td>:</td><td><?php echo $row['kod']?></td></tr>
		<tr><td width="5"/><td>Butiran</td><td>:</td><td><?php echo $row['butiran']?></td></tr>
		<?php if($row['kategori']=='Jabatan'){?>
		<tr><td width="5"/><td>Diketuai Oleh</td><td>:</td><td><?php echo $row['butiran2']?></td></tr>
		<?php } ?>
		<tr><td width="5"/><td colspan="3"><br/><input type="submit" name="Edit" value="EDIT" class="button"/><br/><br/></td></tr>
	</table>	
	</div>
	</form>
<?php
}
?>