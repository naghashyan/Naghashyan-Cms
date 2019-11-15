{block name="cms-bulk-update"}
<div class="edit-box form form-box">
    <form id="addUpdateForm" onsubmit="return false;" class="edit-form">
        {foreach from=$ns.itemIds item=id}
            <input type="hidden" name="item_ids[]" value="{$id}">
        {/foreach}
        <ul class="form-content">
            {foreach from=$ns.fieldsToUpdate item=field key=field_key}
                <li class="form-group">
                    <div class="input-field">
                        <select id="{$field_key}" name="{$field_key}">
                            <option value="">Please select</option>
                            {foreach from=$field["values"] item=value}
                                <option value="{$value["id"]}">{$value["value"]}</option>
                            {/foreach}
                        </select>
                        <label for="{$field_key}">{$field["label"]}</label>
                    </div>
                </li>
            {/foreach}
            {block name="cms-bulk-update-additional-fields"}{/block}
        </ul>

        <div class="form-action">
            <button class="waves-effect waves-light btn f_btn f_cancel">
                Cancel
            </button>
            <button id="saveItem" class="waves-effect waves-light btn green">
                Save
            </button>
            <div class="clear"></div>
        </div>
    </form>
</div>
{/block}

