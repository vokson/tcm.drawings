module.exports = {
    setSortedByItem: (state, value) => state.sortedByItem = value,

    setItems: (state, value) => state.items = value,

    setProperty: (state, payload) => state[payload.property] = payload.value,

    setItemToBeShown: (state, payload) => state.itemsToBeShown[payload.property] = payload.value,

    cleanSearch: (state) => {
        state.nipigaz_code = '';
        state.tcm_code = '';
        state.class = '';
        state.reason = '';
        state.revision = '';
        state.english_title = '';
        state.russian_title = '';
        state.date_beg = '';
        state.date_end = '';
        state.transmittal = '';
    }


}