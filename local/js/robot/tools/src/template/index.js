const TemplateHelper = {

    SPRITE_PATH: '/local/templates/robot/app/dist/assets/icons/sprite.svg#',

    getIcon(icon, iconClass) {
        if (!icon) {
            return '';
        }
        return `<svg ${iconClass ? `class="${iconClass}"` : ''}><use xlink:href="${this.SPRITE_PATH}${icon}"></use></svg>`;
    }
}

 export default TemplateHelper;