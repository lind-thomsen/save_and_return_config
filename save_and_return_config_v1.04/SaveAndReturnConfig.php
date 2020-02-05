<?php
// Set the namespace defined in your config file
namespace OPEN\SaveAndReturnConfig;
// The next 2 lines should always be included and be the same in every module
use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;
// Declare your module class, which must extend AbstractExternalModule 
class SaveAndReturnConfig extends AbstractExternalModule {
    function redcap_every_page_top($project_id) 
    {
		global $showSurveyLoginText, $save_and_return_code_bypass, $public_survey, $survey_auth_enabled, $survey_auth_apply_all_surveys, $survey_auth_enabled_single,$lang;
		$sqTagText=$lang['survey_510'];
		//echo print_r(get_defined_vars());
		// er det survey siden vi er inde på?
		//&& !($showSurveyLoginText || $save_and_return_code_bypass == '1')
		$showqueue = $this -> getProjectSetting('showqueue');
		if(isset($_GET['s']) && $showqueue==0 ){
			?>
			<script language='javascript' type='text/javascript'>
			$(function(){
				var sqLink = document.getElementById("survey_queue_corner");
				if(sqLink != null){
					if(sqLink.getElementsByTagName("A")!=null){
						var aElem = sqLink.getElementsByTagName("A");
						if(aElem != null){
						//var onclickText=aElem[0].getAttribute('onclick').replace(new RegExp('}\\);$'),'hideSqButton();});');
							aElem[0].setAttribute('onclick','');
						  	//forslag: set href til survey queue så der ikke bruge overlay, men skal gemme først.
							aElem[0].innerHTML="";
						}
					}
				}
			})
			</script>
			<?php
		}
		if(isset($_GET['sq']) && $showqueue==0){
			// I tilfælde af survey queue
			?>  
			
			<script language='javascript' type='text/javascript'>
			$(function(){
			
			var surveyQueue = $( ".jqbuttonmed" );
				if( surveyQueue != null ){
					if(surveyQueue[1].innerText="<?php print($sqTagText) ?>"){ //survey_510
						surveyQueue[1].style.visibility = 'hidden';
					}
				}
			})
			</script>
			<?php
			
		}
		//if(isset($_GET['__return']) && ($showSurveyLoginText || $save_and_return_code_bypass == 0)  ){ 
		if(isset($_GET['__return']) && ($showSurveyLoginText || $survey_auth_enabled == 1||$survey_auth_apply_all_surveys==1 || $survey_auth_enabled_single==1 )  ){ 
			//echo print_r($_GET,true)."<br>" ;
						// henter teksten der skal vises
			debugger;
		
			$showText = $this -> getProjectSetting('onpagetext');
			$showcode = $this -> getProjectSetting('showcode');
			$showpopup = $this -> getProjectSetting('showpopup');
			$popuptext = $this -> getProjectSetting('popuptext');
			$logintext = $this -> getProjectSetting('logintext');
			$eboks = $this -> getProjectSetting('eboks');
			?>  
			<script language='javascript' type='text/javascript'>
			
			//jquery ready function
			$(function(){
				//Auto send funktionalitet, kommenteret ud
				//<?php if($eboks =="1") { ?>
				//document.getElementById('email').value='send@openeboksmail.dk';
				//jQuery('#sendLinkBtn').click();
				//<?php } ?>
				
				var email = document.getElementById("provideEmail");
				if(email!=null){
					var provideEmail = email.parentNode;
					
					if(provideEmail!=null){
						var codeText = document.getElementById("codePopupReminderTextCode");
						var popup = document.getElementById("codePopupReminder");
						<?php if($showpopup=="0"){ ?>
							if(popup!=null ){
								popup.remove();
							}
						<?php } ?>
						var returnInstructions = document.getElementById("return_instructions");	
						var continueSurvey =document.getElementById("return_continue_form").parentNode;
						
						<?php if($survey_auth_enabled ==0 or ($survey_auth_apply_all_surveys==0 and $survey_auth_enabled_single==0 )){ ?>
						var instructionElement = 	returnInstructions.getElementsByTagName("div")[0];
						instructionElement.innerHTML="<?php echo "<div>".$showText."</div>" ?>";
						<?php } elseif ($survey_auth_enabled ==1 and ($survey_auth_apply_all_surveys==1 or $survey_auth_enabled_single==1 )){ ?>
						//survey login aktiveret
						var instructionElement = 	returnInstructions.getElementsByTagName("div")[0];
						instructionElement.innerHTML="<?php echo "<div>".$logintext."</div>" ?>";
						//$("b:contains('Link til at vende tilbage til')").text("");
						<?php } ?>
						provideEmail.innerText="";
						<?php if($showcode=="1" ){ ?>
							if(codeText!=null){ 
								returnInstructions.appendChild(codeText);
							 }
							
						<?php } ?>
						returnInstructions.appendChild(continueSurvey);
	
					}
				}
			});
			</script>
			<?php
		}
    }
}
?>
