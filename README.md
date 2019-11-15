# Naghashyan-Cms (NGS CMS)

## Installation

```bash
composer install naghashyan/ngs-php-cms
```

javascript installation

```bash
npm install -g @naghashyan/ngs-builder
```

add js files in builder.json

**JS builder.json file example**
```
{
  "es5": false,
  "out_dir": "htdocs/out/js",
  "es5_out_dir": "htdocs/out/js/es5",
  "compress": true,
  "builders": [
    {
      "source_dir": "",
      "out_dir": "ngs",
      "module": "ngs",
      "files": [
        "NGS.js",
        "Dispatcher.js",
        "AbstractRequest.js",
        "AbstractLoad.js",
        "AbstractAction.js",
        "AjaxLoader.js",
        "CustomEvent.js",
        "NgsEvents.js",
        "UrlObserver.js",
        "util/NgsFormValidator.js"
      ]
    },
    {
      "source_dir": "",
      "out_dir": "ngs/cms",
      "module": "ngs-cms",
      "files": [
        "actions/AbstractAddUpdateAction.js",
        "actions/AbstractDeleteAction.js",
        "loads/AbstractCmsAddUpdateLoad.js",
        "loads/AbstractCmsListLoad.js",
        "loads/AbstractCmsLoad.js",
        "loads/MainCmsLoad.js",
        "lib/jquery.min.js",
        "lib/materialize.min.js",
        "util/MaterialsUtils.js",
        "util/DialogUtility.js",
        "util/NgsFormValidator.js",
        "managers/PagingManager.js",
        "managers/GridManager.js",
        "managers/PageManager.js"
      ]
    }
  ]
}
```

***then run ***
```bash
ngs jupdate -m
```
***for more info please check ngs-builder readme.md***

*if you using windows please run ngs jupdate in administration mode*

**SASS builder.json file example**
```
[
  {
    "output_file": "im-styles.css",
    "compress": true,
    "builders": [
      {
        "output_file": "materialize.css",
        "module": "ngs-cms",
        "type": "lib",
        "files": [
          "materialize/materialize.scss"
        ]
      },
      {
        "output_file": "global_variables.css",
        "type": "variables",
        "module": "ngs-cms",
        "files": [
          "variables/color.scss",
          "variables/structure.scss"
        ]
      },
      {
        "output_file": "modules.css",
        "type": "modules",
        "module": "ngs-cms",
        "files": [
          "modules/global.scss",
          "modules/custom-table.scss",
          "modules/login-content.scss",
          "modules/add-tracks-page.scss",
          "modules/header.scss",
          "modules/dashboard.scss",
          "modules/home-page.scss",
          "modules/side-nav.scss",
          "modules/nano-scroller.scss",
          "modules/pagination.scss",
          "modules/albums.scss",
          "modules/generate-tracks-page.scss",
          "modules/bootstrap-dialog.scss",
          "modules/ui-dialog.scss",
          "modules/form-content.scss",
          "modules/player.scss",
	      "modules/picker.scss",
          "modules/text-editor.scss",
          "modules/page-content.scss",
          "modules/user-popup.scss",
          "modules/input-select-fields.scss"
        ]
      }
    ]
  }
]
```
