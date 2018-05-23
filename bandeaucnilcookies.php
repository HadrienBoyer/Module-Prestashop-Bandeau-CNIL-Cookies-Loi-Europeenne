<?php
/*
 * BANDEAU CNIL Module
 * Auteur: Hadrien Boyer
 * Version: 0.1
 */

if ( !defined( '_PS_VERSION_' ) )
	exit;
class BandeauCNILCookies extends Module
{
	public function __construct()
	{
		$this->name = 'bandeaucnilcookies';
		$this->tab = 'front_office_features';
		$this->version = 0.1;
		$this->author = 'Hadrien Boyer';
		$this->need_instance = 0;
		parent::__construct();
		$this->displayName = $this->l( 'Bandeau CNIL Cookies (Loi européenne)' );
		$this->description = $this->l( "Affichage d'un bandeau avertissant l'utilisateur de l'utilisation de Cookies sur votre site (relatif à la loi européenne et CNIL). Ce bandeau ne s'affiche qu'une seule fois." );
		$this->confirmUninstall = $this->l('Êtes-vous sûr de bien vouloir supprimer ce module ?');
	}
	public function install()
	{
	if (!parent::install() 
		OR !Configuration::updateValue('BANDEAU_CNIL_TEXTE', "Conformément aux directives de la CNIL, pour poursuivre votre navigation dans de bonnes conditions vous devez accepter l'utilisation de Cookies sur notre site.") 
		OR !Configuration::updateValue('BANDEAU_CNIL_TEXTE_BTN', "J'accepte") 
		OR !Configuration::updateValue('BANDEAU_CNIL_POSITION', 0)

		OR !Configuration::updateValue('BANDEAU_CNIL_BACKGROUND_COLOR', "#EEEEEE") 
		OR !Configuration::updateValue('BANDEAU_CNIL_FONT_COLOR', "#777777") 
		OR !Configuration::updateValue('BANDEAU_CNIL_BTN_BACKGROUND_COLOR', "#333333") 
		OR !Configuration::updateValue('BANDEAU_CNIL_BTN_FONT_COLOR', "#FFFFFF") 
		OR !parent::install() 
		OR !$this->registerHook('displayHeader'))		
			return false;
		return true;
	}
	public function uninstall()
	{
		if (!parent::uninstall())
			return false;
		return true;
	}
	public function hookDisplayHeader()
	{
		global $smarty;
		
	//	$this->context->controller->addCSS(($this->_path).'css/bandeaucnilcookies.css', 'all');
		$this->context->controller->addJS(($this->_path).'js/bandeaucnilcookies.js', 'all');
		
			// Configuration
			$texte_bandeau 		= Configuration::get('BANDEAU_CNIL_TEXTE');
			$texte_bouton 		= Configuration::get('BANDEAU_CNIL_TEXTE_BTN');
			$position_bandeau 	= Configuration::get('BANDEAU_CNIL_POSITION');
			// Colors
			$bg_color		 	= Configuration::get('BANDEAU_CNIL_BACKGROUND_COLOR');
			$font_color		 	= Configuration::get('BANDEAU_CNIL_FONT_COLOR');
			$btn_bg_color	 	= Configuration::get('BANDEAU_CNIL_BTN_BACKGROUND_COLOR');
			$btn_font_color 	= Configuration::get('BANDEAU_CNIL_BTN_FONT_COLOR');

			$smarty->assign(array('texte_bandeau' 		=> $texte_bandeau, 
								  'texte_bouton' 		=> $texte_bouton, 
								  'position_bandeau' 	=> $position_bandeau,
								  'bg_color' 			=> $bg_color,
								  'font_color' 			=> $font_color,
								  'btn_bg_color' 		=> $btn_bg_color,
								  'btn_font_color' 		=> $btn_font_color
								  ));
		
		return $this->display( __FILE__, 'bandeaucnilcookies.tpl' );
	}
	
	// CONFIGURATION
	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitBandeauCNIL'))
		{
			$texte = Tools::getValue('texte');
			$texte_btn = Tools::getValue('texte_btn');
			if (!$texte)
				$errors[] = $this->l('Vous devez entrer un texte pour votre Bandeau.');
			elseif (!$texte_btn)
				$errors[] = $this->l('Vous devez entrer un texte pour votre bouton.');
			else {
				Configuration::updateValue('BANDEAU_CNIL_TEXTE', $texte);
				Configuration::updateValue('BANDEAU_CNIL_TEXTE_BTN', $texte_btn);
				Configuration::updateValue('BANDEAU_CNIL_POSITION', intval(Tools::getValue('BANDEAU_CNIL_POSITION')));
				// colors
				Configuration::updateValue('BANDEAU_CNIL_BACKGROUND_COLOR', Tools::getValue('color_bg'));
				Configuration::updateValue('BANDEAU_CNIL_FONT_COLOR', Tools::getValue('color_font'));
				Configuration::updateValue('BANDEAU_CNIL_BTN_BACKGROUND_COLOR', Tools::getValue('color_btn_bg'));
				Configuration::updateValue('BANDEAU_CNIL_BTN_FONT_COLOR', Tools::getValue('color_btn_txt'));

			}
			if (isset($errors) AND sizeof($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		global $cookie;
		
		$output = '
		
			<fieldset style="width: 100%">
				<legend><img src="'.$this->_path.'logo.png" alt="" title="Logo Bandeau CNIL Cookies" />'.$this->l('Configuration du Module').'</legend>
				<form action="'.$_SERVER['REQUEST_URI'].'" method="post">


<h3>Textes</h3>	
	
					<label for="texte">'.$this->l('Texte du Bandeau').'</label>
					<div class="margin-form">
						<input type="text" size="90" id="texte" name="texte" value="'.Tools::getValue('texte', Configuration::get('BANDEAU_CNIL_TEXTE')).'"/>
						<p class="clear">'.$this->l('Entrez le texte du Bandeau').'</p>
					</div>				
	
					<label for="texte_btn">'.$this->l('Texte du bouton').'</label>
					<div class="margin-form">
						<input type="text" id="texte_btn" name="texte_btn" value="'.Tools::getValue('texte_btn', Configuration::get('BANDEAU_CNIL_TEXTE_BTN')).'"/>
						<p class="clear">'.$this->l('Entrez le texte du bouton de fermeture du Bandeau').'</p>
					</div>

<hr>
<h3>Couleurs</h3>		
		
		<script type="text/javascript" src="'.__PS_BASE_URI__.'js/jquery/plugins/jquery.colorpicker.js"></script>
					
					<label for="color_bg">'.$this->l('Couleur de fond du bandeau').'</label>
					<div class="margin-form">
					<input type="text" class="mColorPicker" name="color_bg" id="color_bg" value="'.Tools::getValue('color_bg', Configuration::get('BANDEAU_CNIL_BACKGROUND_COLOR')).'" data-hex="true" /><span id="icp_color_bg" class="mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
						<p class="clear">'.$this->l('Entrez la couleur de fond du Bandeau').'</p>
					</div>

					<label for="color_font">'.$this->l('Couleur du texte').'</label>
					<div class="margin-form">
					<input type="text" class="mColorPicker" name="color_font" id="color_font" value="'.Tools::getValue('color_font', Configuration::get('BANDEAU_CNIL_FONT_COLOR')).'" data-hex="true" /><span id="icp_color_font" class="mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
						<p class="clear">'.$this->l('Entrez la couleur du texte du bandeau').'</p>
					</div>

					<label for="color_btn_bg">'.$this->l('Couleur de fond du Bouton').'</label>
					<div class="margin-form">
					<input type="text" class="mColorPicker" name="color_btn_bg" id="color_btn_bg" value="'.Tools::getValue('color_btn_bg', Configuration::get('BANDEAU_CNIL_FONT_COLOR')).'" data-hex="true" /><span id="icp_color_btn_bg" class="mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
						<p class="clear">'.$this->l('Entrez la couleur du fond du bouton').'</p>
					</div>

					<label for="color_btn_txt">'.$this->l('Couleur du texte du Bouton').'</label>
					<div class="margin-form">
					<input type="text" class="mColorPicker" name="color_btn_txt" id="color_btn_txt" value="'.Tools::getValue('color_btn_txt', Configuration::get('BANDEAU_CNIL_FONT_COLOR')).'" data-hex="true" /><span id="icp_color_btn_txt" class="mColorPickerTrigger" data-mcolorpicker="true"><img src="../img/admin/color.png" /></span>
						<p class="clear">'.$this->l('Entrez la couleur du texte du bouton').'</p>
					</div>				
					
		
<hr>
<h3>Position</h3>		
										
					<label for="BANDEAU_CNIL_POSITION">'.$this->l('Positionner le Bandeau en bas de page').'</label>
					<div class="margin-form">
						<input type="checkbox" id="BANDEAU_CNIL_POSITION" name="BANDEAU_CNIL_POSITION"  value="1" '.(Configuration::get('BANDEAU_CNIL_POSITION') ? 'checked="checked"' : '').' />
						<p class="clear">'.$this->l('Cochez si vous souhaitez voir apparaitre le Bandeau en bas de page').'</p>
					</div>								
					
					<center><input type="submit" name="submitBandeauCNIL" value="'.$this->l('Sauvegarder').'" class="button" /></center>
				</form>
			</fieldset>
			<br class="clear">
		';
			
		$iso_code = Db::getInstance()->ExecuteS('SELECT `iso_code` FROM `'._DB_PREFIX_.'lang` WHERE `active`=1 AND `id_lang`='.$cookie->id_lang);
		$output.= '
				<fieldset style="width: 400px;">
					<legend><img src="../img/admin/manufacturers.gif" /> '.$this->l('Informations').'</legend>
					<div id="dev_div">
						<span><b>'.$this->l('Version').':</b> '.$this->version.'</span><br>
						<span><b>'.$this->l('Auteur').':</b> '.$this->author.'</span><br>
						<span><b>'.$this->l('Website').':</b> <a href="http://hadrien.co">http://hadrien.co</a></span><br>
						<span><b>'.$this->l('Email').':</b> <a href="mailto:hello@hadrien.co">hello@hadrien.co</a></span><br>
					</div>
				</fieldset>
				<br class="clear">
		';		
		
		return $output;
	}
}
?>
