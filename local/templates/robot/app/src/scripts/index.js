/**
 * @param {String} siteTemplatePath
 * @return {void}
 */
function addSiteTemplatePath(siteTemplatePath = '/bitrix') {
    if (!BX) {
        return;
    }
    console.log('siteTemplatePath ', siteTemplatePath);
    BX.namespace("BX.Globals");
    BX.Globals.SiteTemplatePath = siteTemplatePath;
}