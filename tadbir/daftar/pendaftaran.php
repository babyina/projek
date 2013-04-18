<?php
	$pgNum = 1;
	$pgRow = 20;
	if(isset($_GET['page'])){
		$pgNum = $_GET['page'];
	}	
	$offset =($pgNum -1)*$pgRow;
	
	$user_type = "SELECT * FROM kod_sistem WHERE kategori='Jenis Pengguna' ORDER BY kod";	
	
	$advance6 = array("Lihat Laporan","Lihat Agensi","Komen");
	
	function checkBox($name,$value,$label,$checked=""){
		return "<input type=\"radio\" name='$name' value='$value' class=\"noBorder\" $checked>$label";
	}
	
	function advanceBox($items,$name,$value_array){
		foreach($items as $node){
			$checked = in_array($node,$value_array)?"checked":"";
			echo "<input type=\"checkbox\" name=\"$name\" value=\"$node\" $checked>$node";
		}
	}
	
	function senaraiPengguna($conn,$db,$ldapServer,$ldapPort,$base,$def='',$pattern='A'){
		$qry = "SELECT Id FROM pengguna";
		mysql_select_db($db,$conn) or die(mysql_error());
		$result = mysql_query($qry,$conn) or die(mysql_error());
		while($row= mysql_fetch_array($result)){
			$registered[$row['Id']] = $row['Id'];
		}
	
		$connect = ldap_connect($ldapServer);
		if($connect){
			$bind = ldap_bind($connect);
			$search = ldap_search($connect,$base,"cn=$pattern*");
			$info = ldap_get_entries($connect,$search);
			for($i=0;$i<$info["count"];$i++){						
				$id = $info[$i]['uid'][0];
				$name[$id]= $info[$i]['cn'][0];
			}
		}
		if($info["count"]>0){
			asort($name);
			$list = current($name);
			while($list <> null){
				if(key($name)<>$registered[key($name)]){
					if(key($name) <> $def)
						echo "<option value='".key($name)."'>".$list."</option>";
					else
						echo "<option value='".key($name)."' selected>".$list."</option>";
				}
				$list = next($name);
			}	
		}
	}		
	
	//------------------------ operation -------------------------
	mysql_select_db($db_voffice,$conn) or die(mysql_error());	
	if($_POST['Daftar']){			
		$nama = $_POST['nama']; $nama_penuh = $_POST['nama_penuh'];
		$qry = "SELECT Id FROM pengguna WHERE Id='$nama'";
		$result = mysql_query($qry, $conn) or die(mysql_error());
		if(mysql_num_rows($result)>0){
			echo "Pengguna bernama $nama_penuh telah didaftar !";
		}else{
			$Jabatan = $_POST['Jabatan'];$Jawatan=$_POST['Jawatan'];$Emel=$_POST['Emel'];$Jenis=$_POST['Jenis'];$Kategori = $_POST['Kategori'];$Telefon=$_POST['Telefon'];
			$mod1 = $_POST['mod1'];$mod2 = $_POST['mod2'];$mod3= $_POST['mod3'];$mod4 = $_POST['mod4'];$mod5= $_POST['mod5'];$Handphone = $_POST['Handphone'];
			$mod6 = $_POST['mod6'];$advance6 = $_POST['Advance6']<>""?implode(";",$_POST['Advance6']):"";
			$qry = "INSERT INTO pengguna (Id,Nama,Jabatan,Jawatan,Telefon,Handphone,Emel,Kategori,Jenis,Modul1,Modul2,Modul3,Modul4,Modul5,Modul6,Advance6)
			VALUES ('$nama','$nama_penuh','$Jabatan','$Jawatan','$Telefon','$Handphone','$Emel','$Kategori','$Jenis','$mod1','$mod2','$mod3','$mod4','$mod5','$mod6','$advance6')";
			$result = mysql_query($qry) or die(mysql_error());
			echo $save_record_msg;
		}
	}
	elseif($_POST['Kemaskini']){	
		$id = $_GET['id']; $Jawatan = $_POST['Jawatan'];
		$Nama = $_POST['Nama'];$Jabatan = $_POST['Jabatan'];$Telefon = $_POST['Telefon'];
		$Emel = $_POST['Emel'];$Kategori= $_POST['Kategori'];$Jenis = $_POST['Jenis'];
		$mod1 = $_POST['mod1'];$mod2 = $_POST['mod2'];$Handphone = $_POST['Handphone'];
		$mod3=  $_POST['mod3'];$mod4 = $_POST['mod4'];
		$mod5=  $_POST['mod5'];$mod6 = $_POST['mod6'];
		$advance6 = $_POST['Advance6']<>""?implode(";",$_POST['Advance6']):"";
		$qry = "UPDATE pengguna SET Nama='$Nama',Jabatan='$Jabatan',Jawatan='$Jawatan',Telefon='$Telefon',Handphone = '$Handphone',
		Emel='$Emel',Kategori='$Kategori',Jenis='$Jenis',Modul1='$mod1',Modul2='$mod2',Modul3='$mod3',Modul4='$mod4',Modul5='$mod5',Modul6='$mod6',
		Advance6='$advance6'
		WHERE Id='$id'";
		mysql_query($qry,$conn) or die(mysql_error());
		echo $update_record_msg;	
	}
	elseif($_POST['deleteDoc'] && $_GET['mode']=='Pendaftaran'){
		$id = $_POST['id'];
		$qry = "DELETE FROM pengguna WHERE Id='$id'";
		mysql_query($qry) or die(mysql_error());
		echo $delete_record_msg;
	}
	elseif($_GET['action']=='NewDoc'){
		$pattern = isset($_POST['pattern'])?$_POST['pattern']:"A";
		//find user info from ldap......		
		if(isset($_POST['nama'])){
			$nama = $_POST['nama'];
			$ds = ldap_connect($ldapServer);
			if($ds){
				$bind = ldap_bind($ds);
				$search = ldap_search($ds,$ldapBase,"uid=$nama");			
				$info = ldap_get_entries($ds,$search);
				$nama_penuh = $info[0]['cn'][0];
				$emel = $info[0]['mail'][0];
			}
		}	
	?>
	<br/><form name="borang" method="post" action="index.php?mode=Pendaftaran&action=NewDoc">
	<div class="title">Pendaftaran Pengguna</div>
	<div class="box">
	<input type="hidden" name="nama_penuh" value="<?php echo $nama_penuh ?>"/>
		<table>		
		
		<tr><td width="5"/><td width="185"><input type="hidden" name="pattern" value="<?php echo $pattern ?>"/></td><td>:</td><td>
		<input type="submit" onClick="document.borang.pattern.value ='A';document.submit()" value="A" />
		<input type="submit" onClick="document.borang.pattern.value ='B';document.submit()" value="B" />
		<input type="submit" onClick="document.borang.pattern.value ='C';document.submit()" value="C" />
		<input type="submit" onClick="document.borang.pattern.value ='D';document.submit()" value="D" />
		<input type="submit" onClick="document.borang.pattern.value ='E';document.submit()" value="E" />
		<input type="submit" onClick="document.borang.pattern.value ='F';document.submit()" value="F" />
		<input type="submit" onClick="document.borang.pattern.value ='G';document.submit()" value="G" />
		<input type="submit" onClick="document.borang.pattern.value ='H';document.submit()" value="H" />
		<input type="submit" onClick="document.borang.pattern.value ='I';document.submit()" value="I" />
		<input type="submit" onClick="document.borang.pattern.value ='J';document.submit()" value="J" />
		<input type="submit" onClick="document.borang.pattern.value ='K';document.submit()" value="K" />
		<input type="submit" onClick="document.borang.pattern.value ='L';document.submit()" value="L" />
		<input type="submit" onClick="document.borang.pattern.value ='M';document.submit()" value="M" />
		<input type="submit" onClick="document.borang.pattern.value ='N';document.submit()" value="N" />
		<input type="submit" onClick="document.borang.pattern.value ='O';document.submit()" value="O" />
		<input type="submit" onClick="document.borang.pattern.value ='P';document.submit()" value="P" />
		<input type="submit" onClick="document.borang.pattern.value ='Q';document.submit()" value="Q" />
		<input type="submit" onClick="document.borang.pattern.value ='R';document.submit()" value="R" />
		<input type="submit" onClick="document.borang.pattern.value ='S';document.submit()" value="S" />
		<input type="submit" onClick="document.borang.pattern.value ='T';document.submit()" value="T" />
		<input type="submit" onClick="document.borang.pattern.value ='U';document.submit()" value="U" />
		<input type="submit" onClick="document.borang.pattern.value ='V';document.submit()" value="V" />
		<input type="submit" onClick="document.borang.pattern.value ='W';document.submit()" value="W" />
		<input type="submit" onClick="document.borang.pattern.value ='X';document.submit()" value="X" />
		<input type="submit" onClick="document.borang.pattern.value ='Y';document.submit()" value="Y" />
		<input type="submit" onClick="document.borang.pattern.value ='Z';document.submit()" value="Z" />
		</td></tr>
		
		<tr><td width="5"/><td width="185">Nama</td><td>:</td><td><select name="nama" onChange="submit()"><option/><?php senaraiPengguna($conn,$db_voffice,$ldapServer,$ldapPort,$ldapBase,$nama,$pattern)?></select></td></tr>
		<tr><td width="5"/><td width="185">Bahagian/Jabatan/Agensi</td><td>:</td><td><select name="Jabatan"><?php PrintOption($conn,$db_voffice,$query_jabatan) ?></select></td></tr>
		<tr><td width="5"/><td width="185">Jawatan</td><td>:</td><td><input name="Jawatan" class="txt" size="40"></td></tr>
		<tr><td width="5"/><td width="185">No. Telefon</td><td>:</td><td><input name="Telefon" class="txt" size="40" maxlength="12"></td></tr>
		<tr><td width="5"/><td width="185">No. H/p</td><td>:</td><td><input name="Handphone" class="txt" size="40" maxlength="12"></td></tr>
		<tr><td width="5"/><td width="185">Emel</td><td>:</td><td><input name="Emel" size="40" class="txt" value="<?php echo $emel ?>"></td></tr>
		<tr><td width="5"/><td width="185">Kategori Pengguna</td><td>:</td><td><select name="Kategori"><option value="pengguna" selected>Pengguna</option><option value="admin">Administrator</option></td></tr>
		<tr><td width="5"/><td width="185">Jenis Pengguna</td><td>:</td><td><select name="Jenis"><?php PrintOption2($conn,$db_voffice,$user_type) ?></select>
		</td></tr>
		<tr><td width="5"/><td width="185">Id Pengguna</td><td>:</td><td><?php echo $nama ?></td></tr>
		<tr><td width="5"/><td width="185" valign="top">Capaian</td><td valign="top">:</td>
		<td>
			<div class="box">
			<table border="1" style="border-style:solid;border-width:1px;border-color:black">
				<tr bgcolor="#E0EEE0"><td>Maklumbalas Soalan Parlimen</td>
					<td>
						<input type="radio" name="mod1" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod1" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod1" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod1" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod1" value="5" class="noBorder"checked >Tahap 5						
					</td>
				</tr>
				<tr><td>Maklumbalas Jemaah Menteri</td>
					<td>
						<input type="radio" name="mod2" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod2" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod2" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod2" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod2" value="5" class="noBorder"checked >Tahap 5
					</td>
				</tr>
				<!--<tr bgcolor="#E0EEE0"><td>Keputusan Jemaah Menteri</td>
					<td>
						<input type="radio" name="mod6" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod6" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod6" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod6" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod6" value="5" class="noBorder"checked >Tahap 5
						<div>
						<input type="checkbox" name="Advance6[]" value="Lihat Laporan">Lihat Laporan
						<input type="checkbox" name="Advance6[]" value="Lihat Agensi">Lihat Agensi
						<input type="checkbox" name="Advance6[]" value="Komen">Komen
						</div>
					</td>
				</tr> -->
				<tr bgcolor="#E0EEE0"><td>Kalendar Parlimen</td>
					<td>
						<input type="radio" name="mod3" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod3" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod3" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod3" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod3" value="5" class="noBorder"checked >Tahap 5
					</td>
				</tr>
				<tr><td>Profil Ahli Parlimen</td>
					<td>
						<input type="radio" name="mod4" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod4" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod4" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod4" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod4" value="5" class="noBorder"checked >Tahap 5
					</td>
				</tr>				
				<tr bgcolor="#E0EEE0"><td>Pentadbiran Sistem</td>
					<td>
						<input type="radio" name="mod5" value="1" class="noBorder">Tahap 1
						<input type="radio" name="mod5" value="2" class="noBorder">Tahap 2
						<input type="radio" name="mod5" value="3" class="noBorder">Tahap 3
						<input type="radio" name="mod5" value="4" class="noBorder">Tahap 4
						<input type="radio" name="mod5" value="5" class="noBorder"checked >Tahap 5
					</td>
				</tr>
			</table>
			</div>
		</td>
		</tr>
		
		<tr><td width="5"/><td colspan="3"><br/><input type="submit" value="DAFTAR" name="Daftar" class="button"/><br/><br/></td></tr>
	</table>	
	</div>
	</form>
	<?php
	include('level.php');
	}
	elseif($_GET['action']=='list'){
		include('view_pendaftaran.php');		
	}
	elseif($action=='EditDoc' && $_GET['id']){
		$id = $_GET['id'];
		$qry = "SELECT * FROM pengguna WHERE Id = '$id'";
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);		
	?>
		<br/><form name="borang" method="post">
		<div class="title">Pengguna Sistem</div>
		<div class="box">
		<table>		
			<tr><td width="5"/><td width="185">Nama</td><td>:</td><td><input name="Nama" size="45" value="<?php echo $row['Nama']?>" class="txt"></td></tr>
			<tr><td width="5"/><td width="185">Bahagian/Jabatan/Agensi</td><td>:</td><td><select name="Jabatan"><?php PrintOption($conn,$db_voffice,$query_jabatan,$row['Jabatan']) ?></select></td></tr>
			<tr><td width="5"/><td width="185">Jawatan</td><td>:</td><td><input name="Jawatan" size="45" value="<?php echo $row['Jawatan']?>" class="txt"></td></tr>
			<tr><td width="5"/><td width="185">No. Telefon</td><td>:</td><td><input name="Telefon" size="45" value="<?php echo $row['Telefon']?>" class="txt"></td></tr>
			<tr><td width="5"/><td width="185">No. H/p</td><td>:</td><td><input name="Handphone" size="45" value="<?php echo $row['Handphone']?>" class="txt"></td></tr>
			<tr><td width="5"/><td width="185">Emel</td><td>:</td><td><input name="Emel" size="45" value="<?php echo $row['Emel'] ?>" class="txt"></td></tr>
			<tr><td width="5"/><td width="185">Kategori Pengguna</td><td>:</td><td><select name="Kategori"><option value="pengguna" <?php echo ($row['Kategori']=='pengguna')?"selected":""; ?>>Pengguna</option><option value="admin" <?php echo ($row['Kategori']=='admin')?"selected":"" ?>>Administrator</option></td></tr>
			<tr><td width="5"/><td width="185">Jenis Pengguna</td><td>:</td><td><select name="Jenis"><option/><?php PrintOption3($conn,$db_voffice,$user_type,$row['Jenis']) ?></select></td></tr>
			<tr><td width="5"/><td width="185">Id Pengguna</td><td>:</td><td><?php echo $row['Id'] ?></td></tr>
			<tr><td width="5"/><td width="185" valign="top">Capaian</td><td valign="top">:</td>
			<td>
				<div class="box">
				<table border="1" style="border-style:solid;border-width:1px;border-color:black">
					<tr bgcolor="#E0EEE0"><td>Maklumbalas Soalan Parlimen</td>
						<td><?php
						echo checkBox("mod1","1","Tahap 1",($row['Modul1']==1)?"checked":"");
						echo checkBox("mod1","2","Tahap 2",($row['Modul1']==2)?"checked":"");
						echo checkBox("mod1","3","Tahap 3",($row['Modul1']==3)?"checked":"");
						echo checkBox("mod1","4","Tahap 4",($row['Modul1']==4)?"checked":"");
						echo checkBox("mod1","5","Tahap 5",($row['Modul1']==5)?"checked":"");
						?>
						</td>
					</tr>
					<tr><td>Maklumbalas Jemaah Menteri</td>
						<td><?php
						echo checkBox("mod2","1","Tahap 1",($row['Modul2']==1)?"checked":"");
						echo checkBox("mod2","2","Tahap 2",($row['Modul2']==2)?"checked":"");
						echo checkBox("mod2","3","Tahap 3",($row['Modul2']==3)?"checked":"");
						echo checkBox("mod2","4","Tahap 4",($row['Modul2']==4)?"checked":"");
						echo checkBox("mod2","5","Tahap 5",($row['Modul2']==5)?"checked":"");
						?>
						</td>
					</tr>
					<tr>
						<td>Keputusan Jemaah Menteri</td>
						<td><?php
						echo checkBox("mod6","1","Tahap 1",($row['Modul6']==1)?"checked":"");
						echo checkBox("mod6","2","Tahap 2",($row['Modul6']==2)?"checked":"");
						echo checkBox("mod6","3","Tahap 3",($row['Modul6']==3)?"checked":"");
						echo checkBox("mod6","4","Tahap 4",($row['Modul6']==4)?"checked":"");
						echo checkBox("mod6","5","Tahap 5",($row['Modul6']==5)?"checked":"");
						echo "<br/>";
						$value_array = explode(";",$row['Advance6']);
						advanceBox($advance6,"Advance6[]",$value_array);
						?>
						</td>
					</tr>
					<tr bgcolor="#E0EEE0"><td>Kalendar Parlimen</td>
						<td><?php
						echo checkBox("mod3","1","Tahap 1",($row['Modul3']==1)?"checked":"");
						echo checkBox("mod3","2","Tahap 2",($row['Modul3']==2)?"checked":"");
						echo checkBox("mod3","3","Tahap 3",($row['Modul3']==3)?"checked":"");
						echo checkBox("mod3","4","Tahap 4",($row['Modul3']==4)?"checked":"");
						echo checkBox("mod3","5","Tahap 5",($row['Modul3']==5)?"checked":"");
						?>
						</td>
					</tr>
					<tr><td>Profil Ahli Parlimen</td>
						<td><?php
						echo checkBox("mod4","1","Tahap 1",($row['Modul4']==1)?"checked":"");
						echo checkBox("mod4","2","Tahap 2",($row['Modul4']==2)?"checked":"");
						echo checkBox("mod4","3","Tahap 3",($row['Modul4']==3)?"checked":"");
						echo checkBox("mod4","4","Tahap 4",($row['Modul4']==4)?"checked":"");
						echo checkBox("mod4","5","Tahap 5",($row['Modul4']==5)?"checked":"");
						?>
						</td>
					</tr>				
					<tr bgcolor="#E0EEE0"><td>Pentadbiran Sistem</td>
						<td><?php
						echo checkBox("mod5","1","Tahap 1",($row['Modul5']==1)?"checked":"");
						echo checkBox("mod5","2","Tahap 2",($row['Modul5']==2)?"checked":"");
						echo checkBox("mod5","3","Tahap 3",($row['Modul5']==3)?"checked":"");
						echo checkBox("mod5","4","Tahap 4",($row['Modul5']==4)?"checked":"");
						echo checkBox("mod5","5","Tahap 5",($row['Modul5']==5)?"checked":"");
						?>
						</td>
					</tr>
				</table>
				</div>
			</td>
			</tr>
			
			<tr><td width="5"/><td colspan="3"><br/>
			<input type="submit" value="HAPUS" name="Hapus" onClick="return deleteDoc('Pendaftaran','<?php echo $id ?>')" class="button"/>
			<input type="submit" value="SIMPAN" name="Kemaskini"/ class="button">
			<br/><br/></td></tr>			
		</table>	
		</div>
		</form>				
	<?
	include('level.php');
	}
?>