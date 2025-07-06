export default function getFilteredPhrases(prefix, phrasesList = null) {
    let phrasesObj = {};

    (!phrasesList && BX.message)
    && (phrasesList = BX.message);

    for (let key in phrasesList) {
        if (!key.startsWith(prefix)) {
            continue;
        }
        phrasesObj[key] = phrasesList[key];
    }

    return Object.freeze(phrasesObj);
}