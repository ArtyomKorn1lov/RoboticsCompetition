const TemplateHelper = {

    SPRITE_PATH: '/app/dist/assets/icons/sprite.svg#',

    getIcon(icon, iconClass) {
        if (!icon) {
            return '';
        }
        const siteTemplatePath = BX?.Globals?.SiteTemplatePath ?? '/bitrix/templates/robot';
        return `<svg ${iconClass ? `class="${iconClass}"` : ''}><use xlink:href="${siteTemplatePath}${this.SPRITE_PATH}${icon}"></use></svg>`;
    }
}

 export default TemplateHelper;