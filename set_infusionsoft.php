<?php

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) 

{    

    exit('Please don\'t access this file directly.');

}

require_once('config.php'); 
ob_start();
if(isset($_POST) && !empty($_POST))
{       
    if($_POST['submit_infusionsoft_key'] == 'Submit')
    {
        /*
        if(!session_id())
        {
            session_start();
        }
        */
        $user = wp_get_current_user();      

        //Check User is valid or not.   

        if($user->exists()) {
          

            /*      Check API Key is valid or not.                      

            Stript is no provide any method for direct validate API Key then set validation in try catch.           */

            try

            {               

                $inf_app = filter_var($_POST['inf_app'], FILTER_SANITIZE_STRING);   
				
                update_option('SSM_inf_app', $inf_app);                   
				
				$clientId = filter_var($_POST['clientId'], FILTER_SANITIZE_STRING);   
				
                update_option('SSM_clientId', $clientId);   				
				
				$clientSecret = filter_var($_POST['clientSecret'], FILTER_SANITIZE_STRING);   
				
                update_option('SSM_clientSecret', $clientSecret);      				
				
				$access_token = filter_var($_POST['access_token'], FILTER_SANITIZE_STRING);   
				
                update_option('SSM_access_token', $access_token); 				
				
				$refresh_token = filter_var($_POST['refresh_token'], FILTER_SANITIZE_STRING);   
				
                update_option('SSM_refresh_token', $refresh_token);      

                $_SESSION['message']['seccess'] = 'Saved Successfully.';      

            }       

            catch(Exception $e)     

            {           

                $body = $e->getJsonBody();              

                $_SESSION['message']['error'] = $body['error']['message'];                      

            }       
        }
        else {

            $_SESSION['message']['error'] = 'User dose not exists.';        

        }
        
    } 

}

$key1 = get_option('SSM_inf_app');
$key2 = get_option('SSM_inf_key');
$key3 = get_option('SSM_clientId');
$key4 = get_option('SSM_clientSecret');
$key5 = get_option('SSM_access_token');
$key6 = get_option('SSM_refresh_token');

$SSM_inf_app = '';
$SSM_inf_key = '';
$SSM_clientId = '';
$SSM_clientSecret = '';
$SSM_access_token = '';
$SSM_refresh_token = '';

if(!empty($key1))

{ 

    $SSM_inf_app = $key1;

}
if(!empty($key2))

{ 

    $SSM_inf_key = $key2;

}
if(!empty($key3))

{ 

    $SSM_clientId = $key3;

}
if(!empty($key4))

{ 

    $SSM_clientSecret = $key4;

}
if(!empty($key5))

{ 

    $SSM_access_token = $key5;

}
if(!empty($key6))

{ 

    $SSM_refresh_token = $key6;

}

echo '<div class="setting_title">Infusionsoft Settings</div>';



if(isset($_SESSION['message']))

{   

    if(isset($_SESSION['message']['seccess']))  

    {       

        echo '<div class="updated notice"><p>'.$_SESSION['message']['seccess'].'</p></div>';    
        //$_SESSION['message']['error'] = '';
        //$_SESSION['message']['seccess'] = '';           
        session_destroy();
    } 

    elseif(isset($_SESSION['message']['error']))

    {               

        echo '<div class="error notice"><p>'.$_SESSION['message']['error'].'</p></div>';    
        //$_SESSION['message']['seccess'] = ''; 
        //$_SESSION['message']['error'] = '';
        session_destroy();
    }       
    
}

?>



<form class="credit-card1" name="frm" method="post" action="">      



<div class="form-header">       

<h4 class="title">Settings</h4>    

</div>  <div class="form-body"> 

<input type="text" name="inf_app" class="inf_app card-number" value="<?php echo $SSM_inf_app; ?>" placeholder="Infusionsoft App Name">     <!--<input type="text" name="inf_key" class="inf_key card-number" value="<?php //echo $SSM_inf_key; ?>" placeholder="Infusionsoft App Key">-->
<input type="text" name="clientId" class="inf_app card-number" value="<?php echo $SSM_clientId; ?>" placeholder="Infusionsoft clientId"> 
<input type="text" name="clientSecret" class="inf_app card-number" value="<?php echo $SSM_clientSecret; ?>" placeholder="Infusionsoft clientSecret"> 
<input type="text" name="access_token" class="inf_app card-number" value="<?php echo $SSM_access_token; ?>" placeholder="Infusionsoft access_token"> 
<input type="text" name="refresh_token" class="inf_app card-number" value="<?php echo $SSM_refresh_token; ?>" placeholder="Infusionsoft refresh_token"> 
<button type="submit" name="submit_infusionsoft_key" value="Submit" class="proceed-btn">Submit</button>  

</div>

</form>