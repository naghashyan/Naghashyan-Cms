{block name="cms-main"}
  {block name="cms-main-header"}
    <header class="header-box">
      <ul>
        {block name="cms-main-header-load-actions"}
          <li class="menu-button">
            <a id="showHideMenu" href="javascript:void(0);"><i class="material-icons">menu</i></a>
          </li>
          <li class="content-box">
              <div class="search-inner-box">
                  <form id="glbSearch">
                      <div class="search-inner-box">
                          <div class="input-field">
                              <input id="searchKey" type="text" class="validate">
                              <label for="searchKey">Enter here</label>
                          </div>
                          <button type="submit" id="doSearchByKey" class="search-btn">
                              <i class="material-icons">search</i></button>
                      </div>
                  </form>
              </div>
          </li>
        {/block}
        {block name="cms-main-header-page-actions"}
          <li class="search-box">

            <a href="javascript:void(0);" id="showSearch" class="show-search-btn">
              <i class="material-icons">search</i>
            </a>

              <a class="btn waves-effect waves-light green" href="javascript:void(0);" id="addItem">
                  <i class="material-icons">add</i> ADD NEW {$ns.sectionName|upper}
              </a>
          </li>
          <li class="notifi-box"><a href="javascript:void(0);"><i class="material-icons">notifications</i></a></li>
          <li class="logout-box">
            <a href="javascript:void(0);" class="f_menu" data-im-load="admin.loads.main.home"><i
                class="material-icons f_doLogout">power_settings_new</i></a>
          </li>
        {/block}
      </ul>
    </header>
  {/block}
  {block name="cms-main-content"}
    <section>
      {block name="cms-main-content-header"}
        <div class="page-info">
          <p class="title">
            {$ns.sectionName}
          </p>
          <div class="bredcramb">
            <a href="javascript:void(0);" class="f_redirect"
               data-im-load="admin.loads.main.home">
              <i class="material-icons">home</i> Home</a>
            {foreach from=$ns.parentSections item=parentSection name=parentSection}
              <i class="material-icons">keyboard_arrow_right</i>
              {if isset($parentSection["load"])}
                <a href="javascript:void(0);" class="f_redirect"
                   data-im-load="{$parentSection["load"]}">{$parentSection["name"]}</a>
              {else}
                <span>{$parentSection["name"]}</span>
              {/if}
            {/foreach}
            <i class="material-icons">keyboard_arrow_right</i>
            <span>{$ns.sectionName}</span>
          </div>
        </div>
      {/block}

      {block name="cms-main-content-body"}
        <div id="loadContent">
          {nest ns=items_content}
        </div>
      {/block}
      <!-- Table -->
    </section>
  {/block}
{/block}
