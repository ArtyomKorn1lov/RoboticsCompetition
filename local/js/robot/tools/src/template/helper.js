export default class Helper {

    static get SPRITE_PATH() {
        return '/local/templates/robot/app/dist/assets/icons/sprite.svg#';
    }

    getIcon(icon, iconClass) {
        if (!icon) {
            return '';
        }
        return `<svg ${iconClass ? `class="${iconClass}"` : ''}><use xlink:href="${Helper.SPRITE_PATH}${icon}"></use></svg>`;
    }
}