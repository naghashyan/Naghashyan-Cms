import AbstractLoad from '../../AbstractLoad.js';
import DialogUtility from '../util/DialogUtility.js';

export default class MainCmsLoad extends AbstractLoad {

  constructor() {
    super();
  }


  getContainer() {
    return "main";
  }

  onError(params) {

  }

  afterLoad() {
    M.AutoInit();
    this.initMenu();
    this.initOpenSearch();

    /* jQuery("#main_nav .nano").nanoScroller({
       flash: true
     });*/
    $("#m_home").click(function () {
      NGS.load("main.home", {});
    }.bind(this));

    $("#main_container").on("click", ".f_doLogout", function () {
      DialogUtility.showConfirmDialog("Log out", "Are you sure you want to log out ?").then(function (result) {
        NGS.action("admin.actions.main.admin_logout", {})
      }).catch(function () {
        console.log("canceled");
      });
    }.bind(this));
    this.afterCmsLoad();
  }


  initMenu() {
    document.querySelectorAll('#navBar .f_menu').forEach((menuElem) => {
      menuElem.addEventListener('click', (evt) => {
        document.querySelectorAll('#navBar .f_menu').removeClass('active');
        let menuElem = evt.currentTarget;
        menuElem.classList.add('active');
        let ngsLoad = menuElem.getAttribute('data-im-load');
        if(!ngsLoad){
          return false;
        }
        NGS.load(ngsLoad, {});
        return false;
      });
    });

  }

  initOpenSearch() {
    $("#main_container").on("click", "#showSearch", function () {
      $(this).toggleClass('is_active');
    });
  }

  afterCmsLoad() {
  }
}