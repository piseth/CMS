<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
	if(intval($_GET['subj'])==0){
	  redirect("content.php");
	 }
	 include_once("includes/form_functions.php");
	 if(isset($_POST['submit'])){
		 $errors = array();
		 $required= array('menu_name','position','visible','content');
		 $errors=array_merge($errors,check_required_field($required));
		 $fields_with_lengths = array('menu_name' => 30);
		 $errors=array_merge($errors, check_max_length($fields_with_lengths));
	
		$subject_id=mysql_prep($_GET['subj']);
		$menu_name=mysql_prep($_POST['menu_name']);
		$position= mysql_prep($_POST['position']);
		$visible= mysql_prep($_POST['visible']);
		$content=mysql_prep($_POST['content']);
		if(empty($errors)){
		$query="INSERT INTO pages   
				( subject_id, menu_name, content, position, visible)
				VALUES ( {$subject_id}, '{$menu_name}', '{$content}', {$position}, {$visible})";
		$result= mysql_query($query, $connection);
		if(mysql_affected_rows() == 1){
		//success
		$message= "The subject where successfully updated.";		
		}
		else{
		//failed	
		$message="The update did not occur.";
		$message.="The problem was ".mysql_error();
			}
			}
		else{if(count($errors)==1){
			$message="There was 1 error in the form";
		}else{
		//errors occured
		$message="The update did not occur. ";
		$message.=count($errors)." errors.";
		}
	}
	}// end of isset($_GET['submit']
?>
<?php get_selected_page();?>
<?php include("includes/header.php"); ?>
    	<header>
        	<h1>Mango CMS</h1>
        </header>
        <div id="content">
            <aside>
            	<ul id="meny">
         		<?php echo navigation($set_subj,$set_page)?>       
                </ul>
                <a href="content.php">Cancel</a>
            </aside>
            <article>
            	<h2>Add new page</h2>
                <?php if(!empty($errors)){echo"<p class=\"message\"> ".$message." </p>";} ?>
                <?php if(!empty($errors)){display_error($errors);}?>
                <form action="new_page.php?subj=<?php  echo urlencode($set_subj['id']); ?>" method="post">
                <?php $new_page = true; ?>
                <?php include "includes/page_form.php";?>
                <p><input type="submit" name="submit" value="Create Page" />
    			
                </form>		
            </article>    
<?php require("includes/footer.php"); ?>
