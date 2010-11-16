{html_head}<link rel="stylesheet" type="text/css" href="{$REGPHPBB_PATH}admin/template/register_phpbb.css">{/html_head}

<div class="titrePage">
  <h2>{'Title_Tab'|@translate} {$REGPHPBB_VERSION}<br>{'Tab_Synchro'|@translate}</h2>
</div>

<form method="post" action="">
  <fieldset>
  	<legend>{'Sync_Title'|@translate}</legend>
  	{'Sync_Text'|@translate}
    <br>
  	<p><input {$PhpBB_CONFIRM_ENABLE} class="submit" type="submit" value="{'Audit_Btn'|@translate}" name="Audit"> <input onclick="return confirm('{'Are you sure?'|@translate}');" {$PhpBB_CONFIRM_ENABLE} class="submit" type="submit" value="{'Sync_Btn'|@translate}" name="Synchro" {$TAG_INPUT_ENABLED}></p>
  </fieldset>
</form>