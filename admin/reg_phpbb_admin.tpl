<div class="titrePage">
  <h2>{lang:Title}</h2>
</div>

<p>{lang:Howto}</p>

<br />

<div align="left" style="margin-left: 1em; margin-right: 1em;">{lang:Install_Disclaimer}</div>

<br />

<form method="post" action="{RegPhpBB_F_ACTION}" class="general">
<fieldset>
	<legend>{lang:Update}</legend>
	<div align="left">{lang:Update_Disclaimer}</div>
</fieldset>
</form>

<br />

<div align="left" style="margin-left: 1em; margin-right: 1em;">{lang:Install_Disclaimer2}</div>

<br />

<form method="post" action="{RegPhpBB_F_ACTION}" class="general">
<fieldset>
	<legend>{lang:Step1_Title}</legend>
<div align="left">{lang:Step1_Disclaimer}</div>
<ul>
	<li><label>{lang:Phpbb_Prefix}</label><br />
		<div align="center"><label><input type="text" name="phpbb_prefix" value="{PHPBB_PREFIX}" size="8" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:Phpbb_Admin}</label><br /><br />
		<div align="center"><label><input type="text" name="phpbb_admin" value="{PHPBB_ADMIN}" size="12" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:Phpbb_Timezone}</label>
		<div align="center"><label><input type="text" name="phpbb_timezone" value="{PHPBB_TIMEZONE}" size="1" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:Phpbb_Language}</label>
		<div align="center"><label><input type="text" name="phpbb_language" value="{PHPBB_LANGUAGE}" size="8" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:Phpbb_Style}</label>
		<div align="center"><label><input type="text" name="phpbb_style" value="{PHPBB_STYLE}" size="8" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:Phpbb_Del_Pt}</label>
		<div align="center"><label><input type="text" name="phpbb_del_pt" value="{PHPBB_DEL_PT}" size="1" style="text-align: center;"/></label></div><br /><br />
	</li>
	<li><label>{lang:PluginActivation}</label><br />
		<div align="center"><label><input type="text" name="phpbb_status" value="{PHPBB_STATUS}" style="text-align: center;"/></label></div><br /><br />
	</li>
</ul>
	<div align="center"><input class="submit" type="submit" value="{lang:submit}" name="submit" /></div>
</fieldset>
</form>

<form method="post" action="{RegPhpBB_F_ACTION}" class="general">
<fieldset>
	<legend>{lang:Step2_Title}</legend>
	<div align="left">{lang:Step2_Text}</div>
<br/>
	<div align="center">{lang:Step22_Text}</div>
<br/>
	<div align="center"><input class="submit" type="submit" value="{lang:Step2_Btn}" name="Migration" /></div>
<br />
	<div align="left">{lang:Step3_Text}</div>
<br/>
	<div align="center"><input class="submit" type="submit" value="{lang:Step3_Btn}" name="Synchro" /></div>
</fieldset>
</form>