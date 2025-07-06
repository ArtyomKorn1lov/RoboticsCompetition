export default class MediaPopup {
    /** @type {String} */
    url;
    /** @type {String} */
    preview;
    /** @type {String} */
    name;
    /** @type {String} */
    type;
    /** @type {Boolean} */
    isVideo;

    /** @param {MediaPopup} data */
    constructor(data) {
        this.url = data?.url;
        this.preview = data?.preview;
        this.name = data?.name;
        this.type = data?.type;
        this.isVideo = data?.isVideo;
    }
}