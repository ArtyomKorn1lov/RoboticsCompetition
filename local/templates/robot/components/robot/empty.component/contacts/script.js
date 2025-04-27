function initMap(object = null) {
    if (!object) {
        return;
    }

    const options = {
        map: {
            center: object.coords,
            zoom: object.zoom,
            controls: ['smallMapDefaultSet']
        },
        placemark: [
            {
                geometry: object.coords,
                properties: {
                    balloonContentHeader: object.header,
                    balloonContentBody: object.body
                }
            }
        ],
        placemarkDefaults: {
            iconLayout: 'default#image',
            iconImageHref: object.iconPath,
            iconImageSize: object.iconSize
        }
    }

    $(object.mapSelector).eyMaps(options);
}