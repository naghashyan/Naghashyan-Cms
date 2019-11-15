let PageManager = {
  pageParams: {},
  initPageParams: function (pageParams) {
    this.pageParams = pageParams;
  },
  getGlobalParams: function () {
    let params = Object.assign({}, this.getPageParams());
    params.page = 1;
    return params;
  },

  getPageParams: function () {
    return this.pageParams;
  }
};
export default PageManager;