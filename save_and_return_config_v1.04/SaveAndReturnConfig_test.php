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
		global $showSurveyLoginText, $save_and_return_code_bypass, $public_survey, $survey_auth_enabled, $survey_auth_apply_all_surveys, $survey_auth_enabled_single;
		echo print_r(get_defined_vars());
		// er det survey siden vi er inde på?
		//&& !($showSurveyLoginText || $save_and_return_code_bypass == '1')
		//&& $survey_auth_apply_all_surveys == 0 and $survey_auth_enabled_single == 0
		if(isset($_GET['__return'])  ){ 
			//echo print_r($_GET,true)."<br>" ;
						// henter teksten der skal vises
			
			$showText = $this -> getProjectSetting('onpagetext');
			$showcode = $this -> getProjectSetting('showcode');
			$showpopup = $this -> getProjectSetting('showpopup');
			$popuptext = $this -> getProjectSetting('popuptext');
			$logintext = $this -> getProjectSetting('logintext');
			//$eboks = $this -> getProjectSetting('eboks');
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
						
						<?php if($survey_auth_enabled==1 and $survey_auth_apply_all_surveys==0 and $survey_auth_enabled_single==0 ){ ?>
						var instructionElement = 	returnInstructions.getElementsByTagName("div")[0];
						instructionElement.innerHTML="<?php 
						if($survey_auth_apply_all_surveys == 0 and $survey_auth_enabled_single == 0){
						echo "<div>".$showText."</div>" ?>";
						}else{
							echo "<div>".$logintext."</div>" ?>";
						} 
						} ?>
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
