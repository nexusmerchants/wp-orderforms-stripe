<?php

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) 

{    

    exit('Please don\'t access this file directly.');

}

require_once('config.php'); 
ob_start();
if(isset($_POST) && !empty($_POST))
{       
    if($_POST['Submit_api_key'] == 'Submit')
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

                $api_key = filter_var($_POST['api_key'], FILTER_SANITIZE_STRING);   \Stripe\Stripe::setApiKey($api_key);                

                $customer = \Stripe\Customer::all(["limit" => 1]);

                update_option('SSM_stripe_api_key', $api_key);      

                $_SESSION['message']['seccess'] = 'Stripe Secret Key Saved Successfully.';      

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

$key = get_option('SSM_stripe_api_key');

$SSM_api_Key = '';if(!empty($key))

{ 

    $SSM_api_Key = $key;

}

echo '<div class="setting_title">Stripe Settings</div>';



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

<h4 class="title">Set Stripe Secret Key</h4>    

</div>  <div class="form-body"> 

<input type="text" name="api_key" class="api_key card-number" value="<?php echo $SSM_api_Key; ?>" placeholder="Stripe Secret key">      <button type="submit" name="Submit_api_key" value="Submit" class="proceed-btn">Submit</button>  

</div>

</form>