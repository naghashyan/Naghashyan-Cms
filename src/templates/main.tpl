<!DOCTYPE html>
<html lang="en">
<head>
    {block name="head"}
        {block name="header_meta"}
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta name="viewport" content="initial-scale=1.0,width=device-width">
            <link rel="shortcut icon" type="image/x-icon" href="{ngs cmd=get_static_path}/favicon.ico">
            <link rel="icon" type="image/x-icon" href="{ngs cmd=get_static_path}/favicon.ico" sizes="16x16"/>
            <link rel="apple-touch-icon" href="{ngs cmd=get_static_path}/favicon.ico"/>
            <title>{block name="page_title"}NGS CMS{/block}</title>
        {/block}
        {block name="header_controls"}
            {include file="{ngs cmd=get_template_dir ns='ngs-cms'}/util/headerControls.tpl"}
        {/block}
    {/block}
</head>
<body class="blue-color">
{block name='cms_body'}
    {block name="left_bar"}
        <aside id="navBar" class="main-nav">
            {block name="left_bar_content"}
                <div class="logo-content">
                    <div class="logo-block">
                        {block name="main_logo"}
                            <div class="logo-box">
                                NGS
                            </div>
                            <span>CMS</span>
                        {/block}
                    </div>
                </div>
                <ul id="slide-out" class="sidenav">
                    {block name="nav_bar_content"}
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="f_menu waves-effect">
                                <i class="material-icons">dashboard</i> Dashboard
                            </a>
                        </li>
                    {/block}
                </ul>
            {/block}
        </aside>
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
    {/block}
    <section id="main_container" class="main-container">
        {nest ns=content}
    </section>
    <footer>
        {block name='cms_footer'}
        {/block}

    </footer>
    <div id="modal" class="modal ngs-modal">{nest ns=cms_modal}</div>
    <div id="modalPiker" style="display: block;z-index: 2000" class="modal"></div>
    {include file="{ngs cmd=get_template_dir ns='ngs-cms'}/util/dialog.tpl"}
    <div id="ajax_loader" class="ajax-loader">
        {include file="{ngs cmd=get_template_dir ns='ngs-cms'}/util/svg/Rolling-1s-200px.svg"}
    </div>
{/block}
</body>
</html>
