{html_head}<link rel="stylesheet" type="text/css" href="{$REGPHPBB_PATH}admin/template/register_phpbb.css">{/html_head}

<script type="text/javascript">
function blockToggleDisplay(headerId, contentId)
{ldelim}
  var revHeader = document.getElementById(headerId);
  var revContent = document.getElementById(contentId);

  if (revContent.style.display == 'none')
  {ldelim}
    revContent.style.display = 'block';
    revHeader.className = 'instructionBlockHeaderExpanded';
  {rdelim}
  else
  {ldelim}
    revContent.style.display = 'none';
    revHeader.className = 'instructionBlockHeaderCollapsed';
  {rdelim}
{rdelim}

function rfbb_blockToggleDisplay( headerId, contentId )
{ldelim}
  if (typeof(headerId)=='string')
  {ldelim}
   if ( headerId.length>  1)
       blockToggleDisplay(headerId, contentId) ;
      document.getElementById("nb_para").value =headerId ;
      document.getElementById("nb_para2").value =contentId;
  {rdelim}
{rdelim}
</script>

<div class="titrePage">
  <h2>{'Title_Tab'|@translate} {$REGPHPBB_VERSION}<br>{'Tab_Manage'|@translate}</h2>
</div>

<form method="post" action="">
  <fieldset>
  	<legend>{'Config_Title'|@translate}</legend>
    {'Config_Disclaimer'|@translate}
    <br><br>
    <ul>
    	<li><label>{'Prefix'|@translate}</label><br>
    		<input type="text" name="PhpBB_prefix" value={$PhpBB_PREFIX} size="20" style="text-align: center;"><br>
      <br>
    	</li>
    	<li><label>{'Admin'|@translate}</label><br>
    		<input type="text" name="PhpBB_admin" value={$PhpBB_ADMIN} size="20" style="text-align: center;"><br>
      <br>
    	</li>
    	<li><label>{'Guest'|@translate}</label><br>
    		<input type="text" name="PhpBB_guest" value={$PhpBB_GUEST} size="20" style="text-align: center;"><br>
      <br>
    	</li>
    	<li><label>{'Confirm'|@translate}</label><br>
        <input type="radio" value="true" {$PhpBB_CONFIRM_TRUE} name="PhpBB_confirm">{'Confirm_true'|@translate}<br>
        <input type="radio" value="false" {$PhpBB_CONFIRM_FALSE} name="PhpBB_confirm">{'Confirm_false'|@translate}<br>
      <br>
    	</li>
    	<li><label>{'Details'|@translate}</label><br>
        <input type="radio" value="true" {$PhpBB_DETAILS_TRUE} name="PhpBB_details">{'Details_true'|@translate}<br>
        <input type="radio" value="false" {$PhpBB_DETAILS_FALSE} name="PhpBB_details">{'Details_false'|@translate}<br>
      <br>
    	</li>
      {if $UAM_BRIDGE}
    	<li><label>{'Bridge_UAM'|@translate}</label><br>
        <input type="radio" value="true" {$PhpBB_UAM_LINK_TRUE} name="PhpBB_UAM">{'Bridge_UAM_true'|@translate}<br>
        <input type="radio" value="false" {$PhpBB_UAM_LINK_FALSE} name="PhpBB_UAM">{'Bridge_UAM_false'|@translate}<br>
      <br>
      </li>
    	<li><label>{'PhpBB_Group'|@translate}</label><br>
    		<input type="text" name="PhpBB_group" value={$PhpBB_GROUP} size="20" style="text-align: center;"><br>
    	</li>
      {/if}
    </ul>
    <br>
  	<div align="center"><input class="submit" type="submit" value="{'Submit'|@translate}" name="submit" {$TAG_INPUT_ENABLED}></div>
  </fieldset>

  <div id="instructionConfig1" class="instructionBlock" >
    <div id="config1_header" class="instructionBlockHeaderCollapsed" onclick="rfbb_blockToggleDisplay('config1_header', 'Config1')">
        {'About_Reg'|@translate}
      </span>
    </div>

    <div id="Config1" class="instructionBlockContent" style="display:none">
      {'No_Reg_advise'|@translate}
    </div>
  </div>
  <div id="instructionConfig2" class="instructionBlock" >
    <div id="config2_header" class="instructionBlockHeaderCollapsed" onclick="rfbb_blockToggleDisplay('config2_header', 'Config2')">
        {'About_Bridge'|@translate}
      </span>
    </div>

    <div id="Config2" class="instructionBlockContent" style="display:none">
      {'UAM_Bridge_advice'|@translate}
    </div>
  </div>
</form>