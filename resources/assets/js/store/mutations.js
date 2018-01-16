module.exports = {
    setSortedByItem: (state, value) => state.sortedByItem = value,

    setItems: (state, value) => state.items = value,

    setProperty: (state, payload) => state[payload.property] = payload.value,

    setItemToBeShown: (state, payload) => state.itemsToBeShown[payload.property] = payload.value,


}