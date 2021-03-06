<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript">
	function changePaySystem(param)
	{
        $('#paysystem-loader').show();
		if (BX("account_only") && BX("account_only").value == 'Y') // PAY_CURRENT_ACCOUNT checkbox should act as radio
		{
			if (param == 'account')
			{
				if (BX("PAY_CURRENT_ACCOUNT"))
				{
					BX("PAY_CURRENT_ACCOUNT").checked = true;
					BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
					BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');

					// deselect all other
					var el = document.getElementsByName("PAY_SYSTEM_ID");
					for(var i=0; i<el.length; i++)
						el[i].checked = false;
				}
			}
			else
			{
				BX("PAY_CURRENT_ACCOUNT").checked = false;
				BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
				BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
			}
		}
		else if (BX("account_only") && BX("account_only").value == 'N')
		{
			if (param == 'account')
			{
				if (BX("PAY_CURRENT_ACCOUNT"))
				{
					BX("PAY_CURRENT_ACCOUNT").checked = !BX("PAY_CURRENT_ACCOUNT").checked;

					if (BX("PAY_CURRENT_ACCOUNT").checked)
					{
						BX("PAY_CURRENT_ACCOUNT").setAttribute("checked", "checked");
						BX.addClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
					}
					else
					{
						BX("PAY_CURRENT_ACCOUNT").removeAttribute("checked");
						BX.removeClass(BX("PAY_CURRENT_ACCOUNT_LABEL"), 'selected');
					}
				}
			}
		}

		submitForm();
	}
</script>

<?/*<div class="base-card">
	<div class="title big-text">3. Способ оплаты</div>
	<div class="card-content">
		<p class="primary-text">Прямо сейчас</p>
		<p>
			<input type="radio" checked name="payment" value="v1" id="payment-v1"/>
			<label class="radio-lbl" for="payment-v1">Банковской картой 
			<img class="inline-img" src="images/psystems/visa.png"> 
			<img class="inline-img" src="images/psystems/master-card.png"></label>
		</p>
		<p>
			<input type="radio" name="payment" value="v2" id="payment-v2"/>
			<label class="radio-lbl" for="payment-v2">Электронными деньгами 
			<img class="inline-img" src="images/psystems/webmoney.png"> 
			<img class="inline-img" src="images/psystems/yadengi.png"></label>
		</p>
		<p class="primary-text mrg">При получении товара</p>
		<p>
			<input type="radio" name="payment" value="v3" id="payment-v3"/>
			<label class="radio-lbl" for="payment-v3">Наличными</label>
		</p>
		<p>
			<input type="radio" name="payment" value="v4" id="payment-v4"/>
			<label class="radio-lbl" for="payment-v4">Банковской картой
			<img class="inline-img" src="images/psystems/visa.png"> 
			<img class="inline-img" src="images/psystems/master-card.png"></label></label>
		</p>
	</div>
</div>
*/?>

<?
function paySystemPrint($arResult, $arParams, $paymentGroup){
	foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
	{
		if (!in_array($arPaySystem["ID"], $paymentGroup))
			continue;

		if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) > 0 || intval($arPaySystem["PRICE"]) > 0)
		{
			if (count($arResult["PAY_SYSTEM"]) == 1)
			{
				?>
				<p>
					<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
					<input type="radio" id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" name="PAY_SYSTEM_ID"	value="<?=$arPaySystem["ID"]?>"	<?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?> onclick="changePaySystem();"
						/>
					<label class="radio-lbl" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();"><?=$arPaySystem["PSA_NAME"];?>
						<?
						if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
							$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							echo '<img class="inline-img" src="'.$imgUrl.'" />';
						endif;
						?>
					</label>
				</p>

				<?
			}
			else // more than one
			{
			?>
				<p>
					<input type="radio" id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>" <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?> onclick="changePaySystem();" />
					<label class="radio-lbl" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<?=$arPaySystem["PSA_NAME"];?>
						<?
						if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
							$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							echo '<img class="inline-img" src="'.$imgUrl.'" />';
						endif;
						?>
					</label>
				</p>
			<?
			}
		}

		if (strlen(trim(str_replace("<br />", "", $arPaySystem["DESCRIPTION"]))) == 0 && intval($arPaySystem["PRICE"]) == 0)
		{
			if (count($arResult["PAY_SYSTEM"]) == 1)
			{
				?>
				<p>
					<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
					<input type="radio" id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>" <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?> onclick="changePaySystem();" />
					<label class="radio-lbl" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<?=$arPaySystem["PSA_NAME"];?>
						<?
						if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
							$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							echo '<img class="inline-img" src="'.$imgUrl.'" />';
						endif;
						?>
					</label>
				</p>
			<?
			}
			else // more than one
			{
			?>
				<p>
					<input type="radio" id="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>" <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?> onclick="changePaySystem();" />
					<label class="radio-lbl" for="ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>" onclick="BX('ID_PAY_SYSTEM_ID_<?=$arPaySystem["ID"]?>').checked=true;changePaySystem();">
						<?=$arPaySystem["PSA_NAME"];?>
						<?
						if (count($arPaySystem["PSA_LOGOTIP"]) > 0):
							$imgUrl = $arPaySystem["PSA_LOGOTIP"]["SRC"];
							echo '<img class="inline-img" src="'.$imgUrl.'" />';
						endif;
						?>
					</label>
				</p>
			<?
			}
		}
	}
}
?>


<div class="base-card">
    <span class="btn flat fullsize btn-more loader order-loader" id="paysystem-loader" style="display:none;">
        <img src="/local/templates/zakrepi/images/svg/loader.svg" width="40"/>
    </span>
	<div class="title big-text"><?=GetMessage("SOA_TEMPL_PAY_SYSTEM")?></div>
	<div class="card-content">
		<?
		if ($arResult["PAY_FROM_ACCOUNT"] == "Y")
		{
			$accountOnly = ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y") ? "Y" : "N";
			?>
			<input type="hidden" id="account_only" value="<?=$accountOnly?>" />
			<div class="bx_block w100 vertical">
				<div class="bx_element">
					<input type="hidden" name="PAY_CURRENT_ACCOUNT" value="N">
					<label for="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT_LABEL" onclick="changePaySystem('account');" class="<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo "selected"?>">
						<input type="checkbox" name="PAY_CURRENT_ACCOUNT" id="PAY_CURRENT_ACCOUNT" value="Y"<?if($arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y") echo " checked=\"checked\"";?>>
						<div class="bx_logotype">
							<span style="background-image:url(<?=$templateFolder?>/images/logo-default-ps.gif);"></span>
						</div>
						<div class="bx_description">
							<strong><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT")?></strong>
							<p>
								<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT1")." <b>".$arResult["CURRENT_BUDGET_FORMATED"]?></b></div>
								<? if ($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y"):?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT3")?></div>
								<? else:?>
									<div><?=GetMessage("SOA_TEMPL_PAY_ACCOUNT2")?></div>
								<? endif;?>
							</p>
						</div>
					</label>
					<div class="clear"></div>
				</div>
			</div>
			<?
		}

		uasort($arResult["PAY_SYSTEM"], "cmpBySort"); // resort arrays according to SORT value

		echo '<p class="primary-text">Прямо сейчас</p>';
		paySystemPrint($arResult, $arParams, $arParams["PAYMENT_GROUP_1"]);

		echo '<p class="primary-text mrg">При получении товара</p>';
		paySystemPrint($arResult, $arParams, $arParams["PAYMENT_GROUP_2"]);
		?>
	</div>
</div>