<?php
/*-------------------------------------------------------*/
/* Jumpstart Child Theme - Rebel customized for eManager
/* Developed by Matthew M. Emma
/* Support http://www.blackreit.com
/*-------------------------------------------------------*/
/* Ie Check
/*-------------------------------------------------------*/
add_action('wp', 'rebel_iecheck');

function rebel_iecheck(){

	$options = array(	'title' => 'Hey There...',	
						'show_browser_age' => 'true',					
						'browser_page_URI' => 'http://abetterbrowser.org/',
						'message' => '10 years ago a browser was born. Its name was Internet Explorer 6. Now that we are in 2011, in an era of modern web standards, it’s time to say goodbye. There are many benefits of upgrading to a newer version of Internet Explorer – improved speed, tabbed browsing, and better privacy settings to name a few. <br><br>The web has changed a lot over the past 10 years. Browsers have evolved to adapt to new web technologies including HTML5 and CSS3 which bring stunning new features and designs to your websites, and the latest versions also help protect you from new attacks and threats with up to date security patches.  So why not upgrade?',
						'display_mode' => 'fullScreen',
						'last_supported_version' => 11
		);

	$browser_version = 1;
	$years = 0;
	$years_label = " year";

	preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);

	
	if (count($matches)>1){
	  //Then we're using IE
	  $browser_version = (int) $matches[1];

	  switch(true){
	    case ($browser_version<=5):
			$years = date("Y") - 2000;
			break;
		case ($browser_version<=6):
			$years = date("Y") - 2001;
			break;
		case ($browser_version<=7):
			$years = date("Y") - 2006;
			break;
		case ($browser_version<=8):
			$years = date("Y") - 2009;
			break;	
		case ($browser_version<=9):
			$years = date("Y") - 2011;
			break;	
		case ($browser_version<=10):
			$years = date("Y") - 2012;
			break;	
		default:
			$years = date("Y") - 2013;
			break;	
	  }

	if($options['last_supported_version']>$browser_version){

    	$years_label = " years";

    	//this should be the link to the plugin folder, if the path is not the stand it will not work

		echo '<div id="browser-warning" class="browser-feedback '.$options['display_mode'].'">';
		echo '<h3>'.$options['title'].'</h3>';
		
		if($options[ 'show_browser_age' ]=='true'){
			echo '<p>You\'re computer is using Microsoft Internet Explorer '.$browser_version.', a browser over '.$years.$years_label.' old! </p>';
		}
		

		echo '<div class="message">'.$options['message'].'</div>';

		echo '<p class="buttons"><a href="'.$options['browser_page_URI'].'" class="upgrade" target="_blank">Upgrade</a>';

		
		echo '<script type="text/javascript" >
    			function hide_warning(){			    				    				
    				document.getElementById("browser-warning").className  = document.getElementById("browser-warning").className + " hidden";	
    				document.getElementById("browser-warning").style.display="none";				
    			}

    			
    		</script>';
		echo 'or  <a href="javascript:hide_warning();" >continue to website</a>';

	    	
		
			
		echo '</p></div>';

	}



	}

	


}

?>