/**
 * @author Levon Naghashyan
 * @site http://naghashyan.com
 * @mail levon@naghashyan.com
 * @year 2012-2019
 */
let PagingManager = {
  init: function (callBack) {
    let pagingBox = document.getElementById("f_pageingBox");
    if(!pagingBox){
      callBack(false);
      return;
    }
    let currentPage = parseInt(pagingBox.getAttribute("data-im-page"));
    let pageCount = parseInt(pagingBox.getAttribute("data-im-page-count"));
    let currentLimit = parseInt(pagingBox.getAttribute("data-im-limit"));
    pagingBox.querySelectorAll('.f_page').forEach(function (page) {
      page.addEventListener('click', function (evt) {
        let selectedPage = parseInt(pagingBox.getAttribute("data-im-page"));
        goTo(parseInt(evt.currentTarget.getAttribute("data-im-page")));
      });
    });
    document.getElementById("f_go_to_page").addEventListener('keyup', function (evt) {
      if(evt.keyCode === 13){
        goTo(parseInt(evt.currentTarget.value));
      }
    });
    document.getElementById("f_count_per_page").addEventListener('change', function (evt) {
      goTo(1, parseInt(evt.currentTarget.value));
    });
    let goTo = function (page, limit) {
      if(limit && limit !== currentLimit){
        callBack({
          page: page,
          limit: limit
        });
        return;
      }
      if(page !== currentPage && page > 0 && page <= pageCount){
        callBack({
          page: page,
          limit: currentLimit
        });
      }
    };
  },
  getParams: function () {
    let pagingBox = document.getElementById("f_pageingBox");
    if(!pagingBox){
      return {};
    }
    let currentPage = parseInt(pagingBox.getAttribute("data-im-page"));
    let pageCount = parseInt(pagingBox.getAttribute("data-im-page-count"));
    let currentLimit = parseInt(pagingBox.getAttribute("data-im-limit"));
    return {
      page: currentPage,
      limit: currentLimit,
      pageCount: pageCount
    };
  }
};
export default PagingManager;