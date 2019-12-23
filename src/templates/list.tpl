{block name="cms-list"}
    {block name="cms-filter-options"}

    {/block}
    <div class="action-tables table-box">
        <div class="horizontal">
            <form id="cmsFilterBox">
                {block name="cms-filter-section"}
                    <div class="filter-section">
                        {block name="cms-filter-content"}

                        {/block}
                        {block name="cms-filter-btn" hide}
                            <button class="btn-floating btn-large waves-effect waves-light green" type="submit"
                                    id="filterBtn">
                                <i class="material-icons">filter_list</i>
                            </button>
                        {/block}
                    </div>
                {/block}
            </form>
            {block name="cms-bulk-action"}
                {*
                <button class="waves-effect waves-light btn float-left" type="button" id="doBulkAction">Bulk Update
                </button>
                *}
            {/block}
            <div class="space"></div>

            <div class="table bordered_t action_t {block name="cms-table-additional-classes"}{/block}">
                {block name="cms-list-header"}
                    <ul id="gridHeader" class="table-row table-head">
                        {block name="cms-list-header-chechbox-content"}

                        {/block}
                        {block name="cms-list-header-additional-before"}
                        {/block}
                        {foreach from=$ns.visibleFields key=field item=fieldInfo}
                            <li id="{$fieldInfo["data_field_name"]}"
                                    {if $fieldInfo["sortable"]} class="f_sorting sorted {if isset($ns.sortingParam[$fieldInfo["data_field_name"]])} {$ns.sortingParam[$fieldInfo["data_field_name"]]}{/if}" {/if}
                                data-im-sorting="{$fieldInfo["data_field_name"]}"
                                    {if isset($ns.sortingParam[$fieldInfo["data_field_name"]])} data-im-order="{$ns.sortingParam[$fieldInfo["data_field_name"]]}"{/if}>
                                {if isset($fieldInfo["display_name"])}
                                    {$fieldInfo["display_name"]}
                                {else}
                                    {$field}
                                {/if}
                            </li>
                        {/foreach}
                        {if $ns.actions|@count}
                            <li class="action">
                                Actions
                            </li>
                        {/if}
                    </ul>
                {/block}
                {block name="cms-list-content"}
                    <div id="itemsContent" class="table-row-group">
                        {foreach from=$ns.itemDtos item=itemDto name=itemDto}
                            <ul class="table-row {block name="cms-list-content-row-class"}{/block} {if $itemDto->getStatus() AND $itemDto->getStatus() == 'inactive'} inactive {/if}"
                                data-im-id="{$itemDto->getId()}">
                                {block name="cms-list-content-additional-before"}

                                {/block}
                                {block name="cms-list-content-chechbox-content"}

                                {/block}
                                {foreach from=$ns.visibleFields key=field item=fieldInfo}
                                    <li class="mobile-view">
                                        {if isset($fieldInfo["display_name"])}
                                            {$fieldInfo["display_name"]}
                                        {else}
                                            {$field}
                                        {/if}
                                    </li>
                                    {if $fieldInfo["type"] == "long_text"}
                                        <li class="description">
                                            <div class="description-inner">{$itemDto->$field()|strip_tags}</div>
                                        </li>
                                    {else}
                                        <li>
                                            {$itemDto->$field()}
                                        </li>
                                    {/if}
                                {/foreach}
                                {if $ns.actions|@count}
                                    <li class="mobile-view">
                                        Actions
                                    </li>
                                    <li>
                                        <div class="buttons-fixed">
                                            {foreach from=$ns.actions item=action name=action}
                                                <button class="action-btn {$action}-btn f_{$action}_btn"
                                                        data-im-id="{$itemDto->getId()}">
                                                    <i class="large material-icons">{if $action == "play" }play_arrow{elseif $action == "reject"}cancel{elseif $action == "delete"}delete{elseif $action == "edit"}edit{elseif $action == "approve"}check_circle{elseif $action == "tracks"}music_note{elseif $action == "events"}event{else}visibility{/if}</i> {$action}
                                                </button>
                                            {/foreach}
                                        </div>
                                        <div class="buttons-tmp">
                                            {foreach from=$ns.actions item=action name=action}
                                                <button class="action-btn {$action}-btn">
                                                    <i class="large material-icons">{if $action == "play" }play_arrow{elseif $action == "reject"}cancel{elseif $action == "delete"}delete{elseif $action == "edit"}edit{elseif $action == "approve"}check_circle{elseif $action == "tracks"}music_note{elseif $action == "events"}event{else}visibility{/if}</i> {$action}
                                                </button>
                                            {/foreach}
                                        </div>
                                    </li>
                                {/if}
                            </ul>
                        {/foreach}
                    </div>
                {/block}
            </div>
        </div>
        {block name="cms-list-pagination"}
            <div class="action-bar nomargin">
                {include file="{ngs cmd=get_template_dir ns='ngs-cms'}/util/paging_box.tpl"}
            </div>
        {/block}
    </div>
{/block}

{block name="custom-popup"}

{/block}