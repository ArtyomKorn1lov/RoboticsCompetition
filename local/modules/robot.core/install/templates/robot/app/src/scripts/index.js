/**
 * @param {String} siteTemplatePath
 * @return {void}
 */
function addSiteTemplatePath(siteTemplatePath = '/bitrix/templates/robot') {
    if (!BX) {
        return;
    }
    BX.namespace("BX.Globals");
    BX.Globals.SiteTemplatePath = siteTemplatePath;
}