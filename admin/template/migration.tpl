{html_head}<link rel="stylesheet" type="text/css" href="{$REGPHPBB_PATH}admin/template/register_phpbb.css">{/html_head}

<div class="titrePage">
  <h2>{'Title_Tab'|@translate} {$REGPHPBB_VERSION}<br>{'Tab_Migration'|@translate}</h2>
</div>

<form method="post" action="">
  <fieldset>
  	<legend>{'Mig_Title'|@translate}</legend>
  	{'Mig_Text'|@translate}
    <br>
  	<p><input onclick="return confirm('{'Are you sure?'|@translate}');" class="submit" type="submit" value="{'Mig_Btn'|@translate}" name="Migration" {$TAG_INPUT_ENABLED}></p>
    <br>
  	{'Mig_Disclaimer'|@translate}
  </fieldset>
</form>