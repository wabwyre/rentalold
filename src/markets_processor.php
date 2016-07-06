<?php
$processed=0;
switch ($_POST['action'])

{
	
	case add_market_type:
	//values from the form
	$market_code=strtoupper($_POST['maket_code']);
	$market_type_name=strtoupper($_POST['maket_type_nem']);
	$details=strtoupper($_POST['detail']);
	//validation
      if(empty($market_code))
		   {
			$message="You did not enter the market code";
			}
	 else if(empty($market_type_name))
	    {
		$message="You did not enter the market type name";
		}
		else  if(is_numeric($market_type_name))
		{
			$message="The market name is not numeric";
			}
		 else if(empty($details))
		{
			$message="You did enter the market details";
			}
	else	{
	//adding new market type
	$new_market_type="INSERT INTO ".DATABASE.".market_types (market_code,market_type_name,details) VALUES ('$market_code','$market_type_name','$details')";
	$new_market=run_query($new_market_type);
		}
	//check if stored
	 if($new_market_type)
	{
		
		$message="A new record has been added";
		}
	$processed=1;
	break;
	
	case edit_market_type:
	
	$mako=$_POST['maket_type_id'];
	$market_code=strtoupper($_POST['maket_code']);
	$market_type_name=strtoupper($_POST['maket_type_name']);
	$market_detail=strtoupper($_POST['maket_details']);
	//validate
	  if(empty($market_code))
	     {
		$message="You did not enter the market code";
		}
		else if(empty($market_type_name))
		    {
			$message="You did not enter the market type name";
			}
			else if(is_numeric($market_type_name))
          {
			  $message="The market type name is not a number";
		  }
			  else if(empty($market_detail))
			  {
				  $message="You did not enter the market details";
				  }
		  else{
	//edit the market type
	$edit_market_type="UPDATE ".DATABASE.".market_types SET market_code='$market_code',market_type_name='$market_type_name',details='$market_detail' WHERE  market_type_id='$mako'";
	$edit_market=run_query($edit_market_type) or die("error".pg_last_error());
		}
                $processed=1;
	break;
	
	
	if($edit_market)
	{
		$message="You successfully updated the market type";
		}
	$processed=1;
	break;

	case delete_market_type:
	//get the id
	$mark_type=$_POST['mark_type'];
	//delete a market type
	$delete_market="DELETE * FROM ".DATABASE.".market_types WHERE market_type_id=$mark_type";
	
	
	if($delete_market)
	{
		$message="You successfully deleted the market type";
		}
                $processed=1;
	break;
	
	
	case add_market_item:
	$market_item_name=strtoupper($_POST['maket_item_name']);
	$market_item_description=strtoupper($_POST['maket_item_description']);
	
	//validate
	if(empty($market_item_name))
	{
		$message="You need to add the market item name";
		}
		else if(empty($market_item_description))
		{
			$message="You need to add the market item description";
			}
	else
	{
	//add market item
	$add_mitem="INSERT INTO ".DATABASE.".market_items (market_item_name,market_item_description) VALUES ('$market_item_name','$market_item_description')";
	$add_mite=run_query($add_mitem);
	}
	
	if ($add_mite)
	{
		$message="You successfully added a new market item";
		}
                $processed=1;
	break;
	
	case edit_market_item:
	//market items
	$market_item_id=$_POST['maket_item_id'];
	$market_item_name=strtoupper($_POST['maket_item_name']);
	$market_item_description=strtoupper($_POST['maket_item_description']);
	//validate market items
	if(empty($market_item_name))
	{
		$message="You need to add the market item";
		}
		else if(empty($market_item_description))
		{
			$message="You need to add the market item descrption";
			}
	
	else{
	$edit_market_item="UPDATE ".DATABASE.".market_items SET market_item_name='$market_item_name',market_item_description='$market_item_description' WHERE market_item_id=$market_item_id";
	$edit_maket=run_query($edit_market_item);
	}
	
	if ($edit_maket)
	{
		
		$message="You successfully updated the market item";
		}
                $processed=1;
	break;
	
	case add_market_option:
	//market option values
	$option_keyword=$_POST['option_keyword'];
	$option_code=$_POST['option_code'];
	$service_id=$_POST['service_id'];
	$option_nature=$_POST['option_nature'];
	$option_name=$_POST['option_name'];
	$description=$_POST['description'];
	$last_updated=$_POST['last_updated'];
	$leaf=$_POST['leaf'];
	$rate=$_POST['rate'];
	$parent_option_id=$_POST['parent_option_id'];
	//validation
	if(empty($option_keyword))
	{
		$message="You did not enter the option keyword";
		}
		else if(empty($option_code))
		{
			$message="You did not enter the option code";
			}
			else if(empty($service_id))
			{
				$message="You did enter the service id";
				}
				else if(empty($option_nature))
				{
					$message="You did not enter the option nature";
					}
					else if(empty($option_name))
					{
						$message="You did not enter the option name";
						}
						else if (empty($description))
						{
							$message="You did not enter the description";
							}
							else if (empty($last_updated))
							{
								$message="the update date is missing";
								}
								else if(empty($leaf))
								{
									$message="The leaf is missing";
									}
									else if (empty($rate))
									{
										$message="The rate is missing";
										}
										else if(empty($parent_option_id))
                                         {
											 $message="The parent option id is missing";
											 }
											 else if(is_nan($parent_option_id))
											 {
												 $message="The parent option id is supposed to numeric";
												 }
	else
	{
	//store in the db
	$market_option="INSERT INTO ".DATABASE.".options (keyword,option_code,service_id,option_nature,option_name,description,last_updated,leaf,rate,parent_option_id) VALUES ('$option_keyword','$option_code','$service_id','$option_nature','$option_name','$description','$last_updated','$leaf','$rate','$parent_option_id')";
	$market_opt=run_query($market_option);
	}
	
	if($market_opt)
	{
		$message="You successfully added a new market option";
		}
                $processed=1;
	break;


   case edit_market_option:
    //html form values
	$option_id=$_POST['option_id'];
	$option_keyword=$_POST['option_keyword'];
	$option_code=$_POST['option_code'];
	$service_id=$_POST['service_id'];
	$option_nature=$_POST['option_nature'];
	$option_name=$_POST['option_name'];
	$description=$_POST['description'];
	$last_updated=$_POST['last_updated'];
	$leaf=$_POST['leaf'];
	$rate=$_POST['rate'];
	$parent_option_id=$_POST['parent_option_id'];
	//validation
	if(empty($option_keyword))
	{
		$message="You did not enter the option keyword";
		}
		else if(empty($option_code))
		{
			$message="You did not enter the option code";
			}
			else if(empty($service_id))
			{
				$message="You did enter the service id";
				}
				else if(empty($option_nature))
				{
					$message="You did not enter the option nature";
					}
					else if(empty($option_name))
					{
						$message="You did not enter the option name";
						}
						else if (empty($description))
						{
							$message="You did not enter the description";
							}
							else if (empty($last_updated))
							{
								$message="the update date is missing";
								}
								else if(empty($leaf))
								{
									$message="The leaf is missing";
									}
									else if (empty($rate))
									{
										$message="The rate is missing";
										}
										else if(empty($parent_option_id))
                                         {
											 $message="The parent option id is missing";
											 }
											 else if(is_nan($parent_option_id))
											 {
												 $message="The parent option id is supposed to numeric";
												 }
												 else {
	 //update the market options
	 $edit_maket="UPDATE options SET  keyword='$option_keyword',$option_code='$option_code',service_id='$service_id',option_nature='$option_nature',option_name='$option_name',description='$description',last_updated='$last_updated',leaf='$leaf',rate='$rate' WHERE option_id=$option_id";
	$edit_mkt=run_query($edit_mkt);
												 }
	if ($edit_mkt)
	{
		$message="You successfully updated the market option";
		}
                $processed=1;
    break;
	
	
	
	case add_market_attendant:
	//attendant details
	$market_id=$_POST['market_id'];
	$region_id=$_POST['region_id'];
	$is_active=$_POST['isactive'];
	$details=strtoupper($_POST['details']);
	//validate
	if (empty($market_id))
	{
		$message="You did not enter the market id";
		}
		else if(is_nan($market_id))
		{
			$message="The market id is supposed to be a number";
			}
			else if (empty($region_id))
			{
				$message="You did not fill in the region id";
				}
				else if(is_nan($region_id))
				{
					$message="The region id is supposed to a number";
					}
					else if(empty($details))
					{
						$message="You did not enter the details";
						}
			else
			{
	//ADD THE ATTENDANT
	$add_attendant="INSERT INTO ".DATABASE.".market_attendant (market_id,region_id,isactive,details) VALUES ($market_id,$region_id,'$is_active','$details')";
	$add=run_query($add_attendant);
			}
	
	if($add)
	{
		$message="You successfully added a new attendant";
		}
                $processed=1;
	break;
	
	
	
	case edit_market_attendant:
	//attendant new details
	$attendant_id=$_POST['attendant_id'];
	$market_id=$_POST['market_id'];
	$region_id=$_POST['region_id'];
	$is_active=$_POST['isactive'];
	$details=strtoupper($_POST['details']);
	
	//validation
	if (empty($market_id))
	{
		$message="You did not enter the market id";
		}
		else if(is_nan($market_id))
		{
			$message="The market id is supposed to be a number";
			}
			else if (empty($region_id))
			{
				$message="You did not fill in the region id";
				}
				else if(is_nan($region_id))
				{
					$message="The region id is supposed to a number";
					}
					else if(empty($details))
					{
						$message="You did not enter the details";
						}
			else {
	
	//update attendant profile
	$edit_attendant="UPDATE ".DATABASE.".market_attendant SET market_id='$market_id',region_id='$region_id',isactive='$is_active',details='$details' WHERE attendant_id=$attendant_id";
	$edit_attend=run_query($edit_attendant);
			}
	if ($edit_attendant)
	{
		$message="You have successfully updated the attendant's profile";
		}
                $processed=1;
	break;
	}

?>