{block name="cms-add-update"}
    <div class="edit-box form form-box">
        {block name="cms-add-update-title"}
            <h4 class="title" id="modalTitie">some title</h4>
        {/block}
        {block name="cms-modal-close"}
            <div class="modal-close">
                <i class="material-icons">
                    close
                </i>
            </div>
        {/block}
        <form id="addUpdateForm" onsubmit="return false;" class="edit-form">
            {if $ns.itemDto}
                <input type="hidden" name="id" value="{$ns.itemDto->getId()}">
            {/if}
            <ul class="form-content">
                {block name="main-elements"}
                    {foreach from=$ns.visibleFields key=groupName item=groupFields}
                        <li class="form-content-item form-content-count-{$groupFields|count}">
                            {if $groupFields|count > 1}
                                <div class="form-item-group-name">{$groupName}</div>
                            {/if}
                            {foreach from=$groupFields key=field item=fieldInfo}
                                <div class="form-item">
                                    {if $fieldInfo["type"] == "long_text"}
                                        <div class="form-group">
                                            <div class="input-field date-box col s6">
                                                <i class="material-icons prefix">mode_edit</i>
                                                <textarea id="{$fieldInfo["data_field_name"]}_input"
                                                          name="{$fieldInfo["data_field_name"]}"
                                                          class="materialize-textarea"
                                                {if $fieldInfo["required"]} data-ngs-validate='text'{/if}>
                                                    {if $ns.itemDto}{$ns.itemDto->$field()|strip_tags}{/if}</textarea>
                                                <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                            </div>
                                        </div>
                                    {elseif $fieldInfo["type"] == "text"}
                                        <div class="input-field">
                                            <input id="{$fieldInfo["data_field_name"]}_input"
                                                   name="{$fieldInfo["data_field_name"]}" type="text"
                                                   value="{if $ns.itemDto}{$ns.itemDto->$field()}{/if}"
                                                    {if $fieldInfo["required"]} data-ngs-validate='string'{/if}>
                                            <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {elseif $fieldInfo["type"] == "number"}
                                        <div class="input-field">
                                            <input id="{$fieldInfo["data_field_name"]}_input"
                                                   name="{$fieldInfo["data_field_name"]}" type="number"
                                                   value="{if $ns.itemDto}{$ns.itemDto->$field()}{/if}"
                                                    {if $fieldInfo["required"]} data-ngs-validate='float'{/if}>
                                            <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {elseif $fieldInfo["type"] == "date"}
                                        <div class="input-field">
                                            <input id="{$fieldInfo["data_field_name"]}_input"
                                                   name="{$fieldInfo["data_field_name"]}" type="text" class="datepicker"
                                                   placeholder="{$fieldInfo["display_name"]}"
                                                   value="{if $ns.itemDto && $ns.itemDto->$field()}{$ns.itemDto->$field()|date_format:'%d %B %Y'}{/if}">
                                            <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {elseif $fieldInfo["type"] == "time"}
                                        <div class="input-field">
                                            <input id="{$fieldInfo["data_field_name"]}" data-ngs-validate="sting"
                                                   name="{$fieldInfo["data_field_name"]}" type="text" class="timepicker"
                                                   placeholder="{$fieldInfo["display_name"]}"
                                                   value="{if $ns.itemDto}{$ns.itemDto->$field()|date_format:'%H:%M'}{/if}">
                                            <label for="{$fieldInfo["data_field_name"]}">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {elseif $fieldInfo["type"] == "select"}
                                        <div class="input-field">
                                            <select id="{$fieldInfo["data_field_name"]}_input"
                                                    name="{$fieldInfo["data_field_name"]}"
                                                    {if $fieldInfo["required"]} data-ngs-validate='string'{/if}>
                                                <option value="0">Please select</option>
                                                {foreach from=$ns.possibleValues[$fieldInfo["data_field_name"]] item=possibleValue}
                                                    <option value="{$possibleValue["id"]}"
                                                            {if $ns.itemDto AND $possibleValue["id"]==$ns.itemDto->$field()}selected{/if}>{$possibleValue["value"]}</option>
                                                {/foreach}
                                            </select>
                                            <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {elseif $fieldInfo["type"] == "checkbox"}
                                        <div class="input-field-checkbox">
                                            <label>
                                                <input type="checkbox" id="{$fieldInfo["data_field_name"]}"
                                                       name="{$fieldInfo["data_field_name"]}"
                                                       {if $ns.itemDto AND $ns.itemDto->$field()}checked="checked"{/if}
                                                       class="text filled-in">
                                                <span for="{$fieldInfo["data_field_name"]}">{$fieldInfo["display_name"]}</span>
                                            </label>
                                        </div>
                                        {*<div class="input-field-checkbox">*}
                                        {*<input type="checkbox" id="{$fieldInfo["data_field_name"]}_input" name="{$fieldInfo["data_field_name"]}"*}
                                        {*{if $ns.itemDto AND $ns.itemDto->$field()}checked="checked"{/if}*}
                                        {*class="text filled-in">*}
                                        {*<label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>*}
                                        {*</div>*}
                                    {else}
                                        <div class="input-field">
                                            <input id="{$fieldInfo["data_field_name"]}_input"
                                                   name="{$fieldInfo["data_field_name"]}" type="text"
                                                   value="{if $ns.itemDto}{$ns.itemDto->$field()}{/if}">
                                            <label for="{$fieldInfo["data_field_name"]}_input">{$fieldInfo["display_name"]}</label>
                                        </div>
                                    {/if}
                                </div>
                            {/foreach}
                            <div class="space clear"></div>
                        </li>
                    {/foreach}
                {/block}
                {block name="additional-elemets"}

                {/block}
            </ul>


            <div class="double-space"></div>
            <div class="form-action">
                <button class="waves-effect waves-light btn f_cancel" type="button">
                    Cancel
                </button>
                <button id="saveItem" type="submit" class="waves-effect waves-light btn green">
                    Save
                </button>
                <div class="clear"></div>
            </div>
        </form>
    </div>
{/block}

